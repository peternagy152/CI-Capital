<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThemeSettingResource\Pages;
use App\Filament\Resources\ThemeSettingResource\RelationManagers;
use App\Models\ThemeSetting;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
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

class ThemeSettingResource extends Resource
{
    protected static ?string $model = ThemeSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = "Pages";
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make("Header")->schema([
                    Repeater::make('header')->label('Top Header')
                        ->schema([
                            TextInput::make("left_text"),
                            Repeater::make("right_header")->label("Right Side Top Header ")->schema([
                                TextInput::make("text"),
                                TextInput::make("link"),
                            ]),
                        ])->addable(false)->deletable(false)->reorderable(false),
                    Repeater::make('primary_header')
                        ->schema([
                            TextInput::make('item_text')->required(),
                            TextInput::make('item_link')->required()
                        ]),
                ]),

                Repeater::make('theme_settings_1')
                    ->schema([
                        Forms\Components\FileUpload::make('my_account_image')->directory('general')->downloadable()
                            ->openable()->visibility('public'),

                        Section::make("Contact Us - Help And Support")
                            ->schema([
                                TextInput::make("mail"),
                                TextInput::make("phone"),
                                TextInput::make("address"),
                                TextInput::make("address_link"),
                                TextInput::make('help_support_title'),
                                TextArea::make('help_support_desc')->rows(6),
                            ]),

                    ])->addable(false)->deletable(false)->reorderable(false),

                Section::make("Faq Section")->schema([
                    Repeater::make('faqs_header')
                        ->schema([
                            TextInput::make("faqs_title"),
                            TextInput::make("faqs_subtitle"),
                        ])->addable(false)->deletable(false)->reorderable(false),

                    Repeater::make("faqs")
                        ->schema([
                            TextInput::make('question'),
                            TextArea::make('answer')->rows(5),
                            Checkbox::make('show_on_landing_page'),
                        ])->columns(1),
                ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListThemeSettings::route('/'),
            'create' => Pages\CreateThemeSetting::route('/create'),
            'edit' => Pages\EditThemeSetting::route('/{record}/edit'),
        ];
    }
}
