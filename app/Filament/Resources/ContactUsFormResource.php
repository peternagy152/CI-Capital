<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactUsFormResource\Pages;
use App\Filament\Resources\ContactUsFormResource\RelationManagers;
use App\Models\ContactUsForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactUsFormResource extends Resource
{
    protected static ?string $model = ContactUsForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-down-left';
    protected static ?string $navigationGroup = "Forms" ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_email')
                    ->email()->readOnly()
                    ->maxLength(255),

                Forms\Components\Textarea::make('message')
                    ->required()->readOnly()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('user_name')
                    ->required()->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_phone')
                    ->tel()->readOnly()
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_email')
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
            'index' => Pages\ListContactUsForms::route('/'),
            'create' => Pages\CreateContactUsForm::route('/create'),
            'edit' => Pages\EditContactUsForm::route('/{record}/edit'),
        ];
    }
}
