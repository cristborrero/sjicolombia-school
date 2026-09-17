<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Services\CertificateService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $modelLabel = 'Certificado';
    protected static ?string $pluralModelLabel = 'Certificados';
    protected static ?string $navigationLabel = 'Certificados';
    protected static ?string $navigationGroup = 'Gestión Académica';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('enrollment_id')
                    ->label('Inscripción de Estudiante')
                    ->relationship('enrollment')
                    ->getOptionLabelFromRecordUsing(fn (Enrollment $record) => "{$record->user->name} — {$record->course->title}")
                    ->searchable(['user_id', 'course_id'])
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $enrollment = Enrollment::find($state);
                            if ($enrollment) {
                                $set('user_id', $enrollment->user_id);
                                $set('course_id', $enrollment->course_id);
                            }
                        }
                    }),

                Forms\Components\Hidden::make('user_id'),
                Forms\Components\Hidden::make('course_id'),

                Forms\Components\TextInput::make('certificate_code')
                    ->label('Código Único')
                    ->default(fn () => Certificate::generateCode())
                    ->required()
                    ->readOnly(),

                Forms\Components\DateTimePicker::make('issued_at')
                    ->label('Fecha de Emisión')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('certificate_code')
                    ->label('Código')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Código copiado al portapapeles')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.document_number')
                    ->label('Documento')
                    ->formatStateUsing(fn ($record) => $record->user ? CertificateService::maskDocument($record->user->document_type ?? 'CC', $record->user->document_number ?? '') : '—')
                    ->searchable(),

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Curso')
                    ->limit(35)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('issued_at')
                    ->label('Fecha Emisión')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\IconColumn::make('pdf_exists')
                    ->label('PDF')
                    ->state(fn (Certificate $record): bool => !empty($record->pdf_path) && Storage::disk('public')->exists($record->pdf_path))
                    ->boolean()
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-document-minus')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Filtrar por Curso')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('download_pdf')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->url(fn (Certificate $record): string => route('certificate.public.pdf', $record->certificate_code))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('regenerate')
                    ->label('Regenerar PDF')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Certificate $record) {
                        try {
                            app(CertificateService::class)->generatePdf($record);
                            Notification::make()
                                ->title('PDF Regenerado')
                                ->body("El certificado {$record->certificate_code} ha sido generado exitosamente.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Error al regenerar PDF')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('regenerate_batch')
                        ->label('Regenerar PDFs Seleccionados')
                        ->icon('heroicon-o-arrow-path')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $service = app(CertificateService::class);
                            $count = 0;
                            foreach ($records as $record) {
                                try {
                                    $service->generatePdf($record);
                                    $count++;
                                } catch (\Throwable $e) {
                                    // continue
                                }
                            }
                            Notification::make()
                                ->title('Regeneración completada')
                                ->body("Se han regenerado {$count} certificados correctamente.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
