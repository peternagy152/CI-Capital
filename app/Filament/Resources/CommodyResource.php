<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommodyResource\Pages;
use App\Filament\Resources\CommodyResource\RelationManagers;
use App\Models\Commody;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommodyResource extends Resource
{
    protected static ?string $model = Commody::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = "Daily";
    protected static ?string $navigationLabel = "Commodities" ;
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category')
                    ->options([
                        "Energy" => "Energy" ,
                        "Metals" => "Metals" ,
                        "Chemicals" => "Chemicals" ,
                        "Agricultural" => "Agricultural" ,
                        "Food index" => "Food index" ,

                    ])
                    ->required() ,
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
                Forms\Components\Fieldset::make("Records")
                ->schema([
                Forms\Components\TextInput::make('unit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('spot')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('wow')
                    ->label("% W-O-W")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mom')
                    ->label("% M-O-M")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ytd')
                    ->label("% Y-T-D")
                    ->required()
                    ->maxLength(255),
                ])->columns(5),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spot')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wow')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ytd')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListCommodies::route('/'),
            'create' => Pages\CreateCommody::route('/create'),
            'edit' => Pages\EditCommody::route('/{record}/edit'),
        ];
    }
}
