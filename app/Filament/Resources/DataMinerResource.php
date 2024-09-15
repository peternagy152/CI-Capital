<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataMinerResource\Pages;
use App\Filament\Resources\DataMinerResource\RelationManagers;
use App\Models\DataMiner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataMinerResource extends Resource
{
    protected static ?string $model = DataMiner::class;

        protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = "Coverage";
    protected static bool $shouldRegisterNavigation = false;
    // public static function canViewAny(): bool
    // {
    //     return true ;
    // }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                 Forms\Components\Select::make('company_id')
                ->relationship('Company' , 'name')->required() ,
                Forms\Components\Fieldset::make("Data Miner Record")
                ->schema([
                Forms\Components\TextInput::make('parameter')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('py')
                    ->label("Previous Year")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cy')
                 ->label("Current Year")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cy_1')
                ->label("Current Year +1")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cy_2')
                ->label("Current Year +2")
                    ->required()
                    ->maxLength(255),
                ])->columns(5) ,
                Forms\Components\Select::make('type')
                ->options([
                    'bank' => 'Bank',
                    'company' => 'Company',
                    'both' => 'Both',
                ])->required() ,
                   Forms\Components\Select::make('cat')
                ->options([
                    'Income Statement' => 'Income Statement',
                    'Balance Sheet' => 'Balance Sheet',
                    'Cash flow summary' => 'Cash flow summary',
                ])->required() ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parameter')
                    ->searchable(),
                Tables\Columns\TextColumn::make('py')
                    ->label("Previous Year")
                    ->searchable(),
                Tables\Columns\TextColumn::make('cy')
                  ->label("Current Year")
                    ->searchable(),
                Tables\Columns\TextColumn::make('cy_1')
                  ->label("Current Year +1")
                    ->searchable(),
                Tables\Columns\TextColumn::make('cy_2')
                 ->label("Current Year +2")
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat')
                    ->label("Category")
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
                Tables\Filters\SelectFilter::make('Company')
                  ->relationship('Company', 'name')
                  ->preload()
                  ->searchable()


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
            'index' => Pages\ListDataMiners::route('/'),
            'create' => Pages\CreateDataMiner::route('/create'),
            'edit' => Pages\EditDataMiner::route('/{record}/edit'),
        ];
    }
}
