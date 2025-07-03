<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->required()
                    ->maxDate(now()),
                Select::make('type')
                    ->required()
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                    ]),
                Select::make('owner_id')
                    ->required()
                    ->label('Owner')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type'),
                TextColumn::make('owner.name')
                    ->searchable(),
                TextColumn::make('date_of_birth')
                    ->dateTime('d M, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                    ]),
                SelectFilter::make('owner')
                    ->relationship('owner', 'name'),
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
            TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
