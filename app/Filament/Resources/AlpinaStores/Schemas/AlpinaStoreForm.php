<?php

namespace App\Filament\Resources\AlpinaStores\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlpinaStoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('thumbnail')
                    ->required(),
                TextInput::make('address')
                    ->required(),
            ]);
    }
}
