<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $modelLabel = 'Pago';
    protected static ?string $pluralModelLabel = 'Pagos';
    protected static ?string $navigationLabel = 'Pagos';
    protected static ?string $navigationGroup = 'Finanzas y Pagos';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('enrollment_id')
                    ->label('ID de Matrícula')
                    ->relationship('enrollment', 'id')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Usuario / Pagador')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('gateway')
                    ->label('Pasarela de Pago')
                    ->options([
                        'bold' => 'Bold',
                        'epayco' => 'ePayco',
                        'manual' => 'Transferencia Manual',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('gateway_transaction_id')
                    ->label('ID de Transacción Pasarela'),
                Forms\Components\TextInput::make('gateway_reference')
                    ->label('Referencia Única de Pago'),
                Forms\Components\TextInput::make('amount_cop')
                    ->label('Monto (COP)')
                    ->prefix('$')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_method')
                    ->label('Método de Pago (PSE, Tarjeta, etc.)'),
                Forms\Components\Select::make('status')
                    ->label('Estado de la Transacción')
                    ->options([
                        'pending' => 'Pendiente',
                        'successful' => 'Aprobado / Exitoso',
                        'failed' => 'Fallido / Rechazado',
                        'refunded' => 'Reembolsado',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\Textarea::make('raw_webhook_payload')
                    ->label('Datos Crudos del Webhook (JSON)')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('paid_at')
                    ->label('Fecha y Hora del Pago'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gateway_reference')
                    ->label('Referencia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente / Usuario')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gateway')
                    ->label('Pasarela')
                    ->badge(),
                Tables\Columns\TextColumn::make('amount_cop')
                    ->label('Monto (COP)')
                    ->money('COP', locale: 'es_CO')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'successful' => 'Aprobado',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'successful' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Fecha de Pago')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
