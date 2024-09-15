<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchServiceResource\Pages;
use App\Filament\Resources\ResearchServiceResource\RelationManagers;
use App\Models\ResearchService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ResearchServiceResource extends Resource
{
    protected static ?string $model = ResearchService::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = "Pages";
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('header')
                    ->schema([
                        TextInput::make('top')->required(),
                        TextInput::make('title')->required(),
                    ])->addable(false)->reorderable(false)->deletable(false),


                Repeater::make('repeated_section')
                    ->schema([
                        TextInput::make('title')->required(),
                        TextArea::make('desc')->rows(6),
                Forms\Components\FileUpload::make('right_image')->label("Image - 110 x 110 ")->directory('general')->preserveFilenames()->downloadable()
                ->openable()->visibility('public'),
                    ]),

                Repeater::make('thanks_page')
                    ->schema([
                        TextArea::make('thanks_page_text1')->rows(4),
                        TextArea::make('thanks_page_text2')->rows(2),
                    ])->addable(false)->reorderable(false)->deletable(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('id')
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                ->sortable(),
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
            'index' => Pages\ListResearchServices::route('/'),
            'create' => Pages\CreateResearchService::route('/create'),
            'edit' => Pages\EditResearchService::route('/{record}/edit'),
        ];
    }
}
