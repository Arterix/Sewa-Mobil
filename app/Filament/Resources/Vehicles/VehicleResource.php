<?php

namespace App\Filament\Resources\Vehicles;

use App\Filament\Resources\Vehicles\Pages\CreateVehicle;
use App\Filament\Resources\Vehicles\Pages\EditVehicle;
use App\Filament\Resources\Vehicles\Pages\ListVehicles;
use App\Filament\Resources\Vehicles\Schemas\VehicleForm;
use App\Filament\Resources\Vehicles\Schemas\VehicleInfoList;
use App\Filament\Resources\Vehicles\Tables\VehiclesTable;
use App\Models\Vehicle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Vehicle';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Fieldset::make('Details')
            -> schema([
                TextInput::make('name')
                    -> required()
                    -> maxLength(255),

                Select::make('is_popular')->options([
                    true=>'Popular', false=>'Not Popular'
                    ])-> required(),

                FileUpload::make('thumbnail')
                    -> image()
                    -> required(),

                Repeater::make('photos')
                    -> relationship('photos')
                    -> schema([
                        FileUpload::make('photo')
                            -> image()
                            -> required(),
                    ]),
            ]),
            Fieldset::make('Additional')
            ->schema([
                TextInput::make('horse_power')
                    -> required()
                    -> numeric()
                    -> prefix('HP'),

                TextInput::make('max_speed')
                    -> required()
                    -> numeric()
                    -> prefix('KmH'),

                TextInput::make('cc')
                    -> required()
                    -> numeric()
                    -> prefix('Power CC'),

                TextInput::make('about')
                    -> required(),
                
                TextInput::make('duration')
                    -> required()
                    -> numeric()
                    -> prefix('Days'),

                TextInput::make('price')
                    -> required()
                    -> numeric()
                    -> prefix('IDR'),

                TextInput::make('category_id')
                    -> relationship('category', 'name')
                    -> searchable()
                    -> preload()
                    -> required(),
            ]),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VehicleInfoList::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehiclesTable::configure($table);
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
            'index' => ListVehicles::route('/'),
            'create' => CreateVehicle::route('/create'),
            'edit' => EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
