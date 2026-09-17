<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $modelLabel = 'Inscripción';
    protected static ?string $pluralModelLabel = 'Inscripciones';
    protected static ?string $navigationLabel = 'Inscripciones';
    protected static ?string $navigationGroup = 'Gestión Académica';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Estudiante')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label('Curso')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Estado de Matrícula')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada / Activa',
                        'cancelled' => 'Cancelada',
                        'completed' => 'Completada',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\DateTimePicker::make('enrolled_at')
                    ->label('Fecha de Inscripción'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Estudiante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'cancelled' => 'Cancelada',
                        'completed' => 'Completada',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Fecha de Matrícula')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_certificate')
                    ->label('Certificado')
                    ->state(fn (Enrollment $record): bool => $record->certificate()->exists())
                    ->boolean()
                    ->trueIcon('heroicon-o-academic-cap')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('success')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('issue_certificate')
                    ->label('Emitir Certificado')
                    ->icon('heroicon-o-academic-cap')
                    ->color('warning')
                    ->visible(fn (Enrollment $record) => !$record->certificate()->exists() && in_array($record->status, ['confirmed', 'completed']))
                    ->requiresConfirmation()
                    ->action(function (Enrollment $record) {
                        $cert = app(\App\Services\CertificateService::class)->issueForEnrollment($record);
                        \Filament\Notifications\Notification::make()
                            ->title('Certificado Emitido')
                            ->body("Certificado {$cert->certificate_code} emitido con éxito.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('issue_certificates_bulk')
                        ->label('Emitir Certificados en Lote')
                        ->icon('heroicon-o-academic-cap')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $service = app(\App\Services\CertificateService::class);
                            $count = 0;
                            foreach ($records as $record) {
                                if (!$record->certificate()->exists() && in_array($record->status, ['confirmed', 'completed'])) {
                                    $service->issueForEnrollment($record);
                                    $count++;
                                }
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Certificados Emitidos')
                                ->body("Se han emitido {$count} certificados correctamente.")
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
