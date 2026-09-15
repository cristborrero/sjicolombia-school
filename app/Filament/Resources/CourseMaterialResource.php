<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseMaterialResource\Pages;
use App\Filament\Resources\CourseMaterialResource\RelationManagers;
use App\Models\CourseMaterial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseMaterialResource extends Resource
{
    protected static ?string $model = CourseMaterial::class;

    protected static ?string $modelLabel = 'Material de Curso';
    protected static ?string $pluralModelLabel = 'Materiales de Curso';
    protected static ?string $navigationLabel = 'Materiales';
    protected static ?string $navigationGroup = 'Gestión Académica';
    protected static ?string $navigationIcon = 'heroicon-o-folder-arrow-down';

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
                Forms\Components\Select::make('course_session_id')
                    ->label('Sesión Asociada (Opcional)')
                    ->relationship('courseSession', 'title')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->label('Título del Material')
                    ->required(),
                Forms\Components\TextInput::make('file_path')
                    ->label('Ruta o Nombre del Archivo')
                    ->required(),
                Forms\Components\TextInput::make('file_type')
                    ->label('Tipo de Archivo (ej. PDF, PPTX)'),
                Forms\Components\TextInput::make('file_size_bytes')
                    ->label('Tamaño en Bytes')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_type')
                    ->label('Tipo')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Ruta / Archivo')
                    ->limit(30),
                Tables\Columns\TextColumn::make('file_size_bytes')
                    ->label('Tamaño')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 1) . ' KB' : '-')
                    ->sortable(),
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
            'index' => Pages\ListCourseMaterials::route('/'),
            'create' => Pages\CreateCourseMaterial::route('/create'),
            'edit' => Pages\EditCourseMaterial::route('/{record}/edit'),
        ];
    }
}
