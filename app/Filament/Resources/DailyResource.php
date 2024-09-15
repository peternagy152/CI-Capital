<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyResource\Pages;
use App\Filament\Resources\DailyResource\RelationManagers;
use App\Models\Daily;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyResource extends Resource
{
    protected static ?string $model = Daily::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = "Daily";
    protected static ?string $navigationLabel = "Daily | For Companies";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('source_id')->relationship("Source", "name")->preload()->required()->multiple(),
                Forms\Components\Select::make('company_id')->relationship("Company" , "name")
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('desc')
                    ->label("Content")
                    ->rows(8)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_at')    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->searchable(),
                Tables\Columns\TextColumn::make('Company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Source.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->sortable() ,
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
            'index' => Pages\ListDailies::route('/'),
            'create' => Pages\CreateDaily::route('/create'),
            'edit' => Pages\EditDaily::route('/{record}/edit'),
        ];
    }
}
