<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MacroPublicationResource\Pages;
use App\Filament\Resources\MacroPublicationResource\RelationManagers;
use App\Models\MacroPublication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\Analyst;

class MacroPublicationResource extends Resource
{
    protected static ?string $model = MacroPublication::class;

     protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationLabel = "Publications | For Macros";
    protected static ?string $navigationGroup = "Reports";

    public static function form(Form $form): Form
    {

        $all_analyst = array();
        foreach(Analyst::all() as $one_analyst){
            $user = User::find($one_analyst->user_id);
            $all_analyst[$one_analyst->id] = $user->name ;
        }
        return $form

            ->schema([
                 Forms\Components\Select::make('macro_id')->relationship("Macro" , "name")
                    ->required() ,
            //     Forms\Components\Select::make('analyst_id')
            //    ->options($all_analyst)
            //         ->required() ,
              Forms\Components\Select::make('analyst_id')
                    ->label("Analysts")
                    ->relationship('Analyst' , 'id')->multiple()->preload()->options($all_analyst)
                    ->required() ,

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('desc')
                    ->label("Description")
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('read_in')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('published_at')    ->native(false)
                    ->required(),

                Forms\Components\FileUpload::make('report')->directory('macro_publications')->downloadable()->openable()->visibility('public')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Macro.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('read_in')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->searchable()
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
            'index' => Pages\ListMacroPublications::route('/'),
            'create' => Pages\CreateMacroPublication::route('/create'),
            'edit' => Pages\EditMacroPublication::route('/{record}/edit'),
        ];
    }
}
