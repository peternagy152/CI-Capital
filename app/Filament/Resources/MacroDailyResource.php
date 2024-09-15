<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MacroDailyResource\Pages;
use App\Filament\Resources\MacroDailyResource\RelationManagers;
use App\Models\MacroDaily;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MacroDailyResource extends Resource
{
    protected static ?string $model = MacroDaily::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationGroup = "Daily";
    protected static ?string $navigationLabel = "Daily | For Macros";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('source_id')->relationship("Source" , "name")
                    ->multiple()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('macro_id')->relationship("Macro" , "name")
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('desc')
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
                  Tables\Columns\TextColumn::make('Macro.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Source.name')
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
            'index' => Pages\ListMacroDailies::route('/'),
            'create' => Pages\CreateMacroDaily::route('/create'),
            'edit' => Pages\EditMacroDaily::route('/{record}/edit'),
        ];
    }
}
