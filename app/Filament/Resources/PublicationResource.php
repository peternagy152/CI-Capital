<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Analyst;
use App\Models\User;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

   protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationGroup = "Reports";
    protected static ?string $navigationLabel = "Publications | For Companies ";

    public static function form(Form $form): Form
    {
         $all_analyst = array();
        foreach(Analyst::all() as $one_analyst){
            $user = User::find($one_analyst->user_id);
            $all_analyst[$one_analyst->id] = $user->name ;
        }
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')->relationship("Company" , "name")->multiple()->preload()
                    ->required() ,
              Forms\Components\Select::make('analyst_id')
                    ->label("Analysts")
                    ->relationship('Analyst' , 'id')->multiple()->preload()->options($all_analyst)
                    ->required() ,
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('desc')
                    ->label("Description")
                    ->rows(8)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('read_in')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('published_at')    ->native(false)
                    ->required(),
                Forms\Components\FileUpload::make('report')->directory('publications')->downloadable()->openable()->visibility('public')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Company.name')
                    ->label("Company")
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
