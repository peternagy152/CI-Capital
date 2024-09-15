<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceInquiryResource\Pages;
use App\Filament\Resources\ServiceInquiryResource\RelationManagers;
use App\Models\ServiceInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceInquiryResource extends Resource
{
    protected static ?string $model = ServiceInquiry::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle' ;
    protected static ?string $navigationGroup = "Forms" ;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric()->readOnly() ,
                Forms\Components\TextInput::make('service')
                    ->required()->readOnly()
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()->readOnly() ,
                Forms\Components\TextInput::make('user_name')
                    ->required()->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_phone')
                    ->tel()
                    ->required()->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_email')
                    ->email()->readOnly()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_phone')
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
            'index' => Pages\ListServiceInquiries::route('/'),
            'create' => Pages\CreateServiceInquiry::route('/create'),
            'edit' => Pages\EditServiceInquiry::route('/{record}/edit'),
        ];
    }
}
