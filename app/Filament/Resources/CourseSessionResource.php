<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSessionResource\Pages;
use App\Filament\Resources\CourseSessionResource\RelationManagers;
use App\Models\CourseSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseSessionResource extends Resource
{
    protected static ?string $model = CourseSession::class;

    protected static ?string $modelLabel = 'Sesión';
    protected static ?string $pluralModelLabel = 'Sesiones de Clase';
    protected static ?string $navigationLabel = 'Sesiones';
    protected static ?string $navigationGroup = 'Gestión Académica';
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Curso')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('Título de la Sesión')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción de la Sesión')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->label('Fecha y Hora Programada'),
                Forms\Components\TextInput::make('meet_url')
                    ->label('Enlace de Reunión (Google Meet / Zoom)')
                    ->url(),
                Forms\Components\Select::make('meet_source')
                    ->label('Plataforma')
                    ->options([
                        'google_meet' => 'Google Meet',
                        'zoom' => 'Zoom',
                        'manual' => 'Manual / Otro',
                    ])
                    ->default('google_meet')
                    ->required(),
                Forms\Components\TextInput::make('order_index')
                    ->label('Número / Orden de la Sesión')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_index')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título de Sesión')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('meet_source')
                    ->label('Plataforma')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('meet_url')
                    ->label('Enlace')
                    ->limit(30),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListCourseSessions::route('/'),
            'create' => Pages\CreateCourseSession::route('/create'),
            'edit' => Pages\EditCourseSession::route('/{record}/edit'),
        ];
    }
}
