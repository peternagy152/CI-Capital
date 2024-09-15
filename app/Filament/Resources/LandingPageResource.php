<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingPageResource\Pages;
use App\Filament\Resources\LandingPageResource\RelationManagers;
use App\Livewire\ImagePreview;
use App\Models\LandingPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class LandingPageResource extends Resource
{
    protected static ?string $model = LandingPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = "Pages";
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form

            ->schema([
            // Hero Section
            Section::make("Hero Section")
                ->schema([
                    Repeater::make('nav')
                        ->schema([
                        TextInput::make('name')->required(),
                    ]), Repeater::make('hero_section')
                ->schema([
                    TextInput::make('title')->required(),
                    TextArea::make('subtitle')->required()->rows(8),
                    TextInput::make('button_text')->required(),
                    TextInput::make('button_link')->required(),
                ])->addable(false)->deletable(false)->reorderable(false),


            ])->columns(2),


            // About Section
            Section::make("About Section")
            ->schema([Repeater::make('section_about')
                    ->schema([
                        section::make("Top Section")->schema([
                            TextInput::make('title')->required(),
                            TextInput::make('subtitle')->required(),
                            Textarea::make('desc')->required()->rows(8) ,
                        ]),
                        Section::make("Right Section")->schema([
                            TextInput::make('right_section_title')->required(),
                            Textarea::make('right_section_desc')->required()->rows(8),
                            TextInput::make('right_section_button_text')->required(),
                            TextInput::make('right_section_button_link')->required(),
                        ]) ,

                    ])->addable(false)->deletable(false)->reorderable(false)->columns(2),

                Repeater::make('about_repeater')
                    ->schema([
                        TextInput::make('title'),
                        TextArea::make('subtitle')->rows(4),
                        Forms\Components\FileUpload::make('about_image')->directory('landing_page')->downloadable()
                            ->openable()->visibility('public')->label('Image - 128x124'),
                    ])->addActionLabel('Add Item'),


            ])->columns(2),

            Section::make("How to navigate")
            ->schema([
                Repeater::make('navigate_section')
                    ->schema([
                        TextInput::make('title'),
                        TextArea::make('subtitle')->rows(3),
                        Forms\Components\FileUpload::make('navigate_image')->directory('landing_page')->downloadable()
                      ->label("Video Cover - 684x440 ")->openable()->visibility('public'),

                        TextInput::make('video_link'),
                    ])->addable(false)->reorderable(false)->deletable(false),

                Repeater::make('navigate_steps')
                ->schema([
                    TextInput::make('step_name')->required(),
                    TextInput::make('step_desc')->required(),
                ]),
            ]),

//
//            Section::make('FAQs Section')
//                ->description("Add Questions and Answers")
//                ->schema([
//                    Repeater::make('faqs_header')
//                        ->schema([
//                            TextInput::make('faqs_top')->required(),
//                            TextInput::make('faqs_header')->required(),
//                        ])->addable(false)->reorderable(false)->deletable(false),
//
//                Repeater::make('faqs')
//                ->schema([TextInput::make('question')->required(),
//                            TextArea::make('answer')->rows(4),
//                        ]),
//                ]),

            Repeater::make('request_form_header')
                ->schema([
                    TextInput::make('title')->required(),
                    TextInput::make('subtitle')->required(),
                ])->addable(false)->deletable(false)->reorderable(false),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
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
            'index' => Pages\ListLandingPages::route('/'),
            'create' => Pages\CreateLandingPage::route('/create'),
            'edit' => Pages\EditLandingPage::route('/{record}/edit'),
        ];
    }
}
