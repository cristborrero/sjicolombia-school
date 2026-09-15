<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $modelLabel = 'Curso';
    protected static ?string $pluralModelLabel = 'Cursos';
    protected static ?string $navigationLabel = 'Cursos';
    protected static ?string $navigationGroup = 'Gestión Académica';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título del Curso')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Enlace Permanente (Slug)')
                    ->required(),
                Forms\Components\Textarea::make('short_description')
                    ->label('Descripción Corta')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('syllabus')
                    ->label('Temario / Plan de Estudios')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price_cop')
                    ->label('Precio (COP)')
                    ->prefix('$')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('hours_intensity')
                    ->label('Intensidad Horaria (Horas)')
                    ->suffix('horas')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('max_capacity')
                    ->label('Capacidad Máxima (Cupos)')
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->label('Estado del Curso')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'in_progress' => 'En Curso',
                        'completed' => 'Finalizado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->default('draft')
                    ->required(),
                Forms\Components\FileUpload::make('cover_image_path')
                    ->label('Imagen de Portada')
                    ->image()
                    ->directory('courses'),
                Forms\Components\Select::make('teacher_id')
                    ->label('Docente Asignado')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Fecha y Hora de Inicio'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image_path')
                    ->label('Portada'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Docente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_cop')
                    ->label('Precio (COP)')
                    ->money('COP', locale: 'es_CO')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hours_intensity')
                    ->label('Horas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_capacity')
                    ->label('Cupos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'in_progress' => 'En Curso',
                        'completed' => 'Finalizado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'in_progress' => 'info',
                        'completed' => 'primary',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Fecha de Inicio')
                    ->dateTime('d/m/Y H:i')
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
