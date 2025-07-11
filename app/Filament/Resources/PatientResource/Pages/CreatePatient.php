<?php

namespace App\Filament\Resources\PatientResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PatientResource;


class CreatePatient extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = PatientResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Name')
                ->description('The name of the pet.')
                ->schema([
                    PatientResource::getNameFormField(),
                ]),
            Step::make('Date of Birth')
                ->description('The date of birth of the pet.')
                ->schema([
                    PatientResource::getDOBFormField(),
                ]),
            Step::make('Type')
                ->description('The type of pet.')
                ->schema([
                    PatientResource::getTypeFormField(),
                ]),
            Step::make('Owner')
                ->description('The owner of the pet.')
                ->schema([
                    PatientResource::getOwnerFormField(),
                ]),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
