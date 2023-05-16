<?php

namespace JustBetter\AkeneoProductsNova\Nova;

use JustBetter\AkeneoProducts\Enums\MappingType;
use JustBetter\AkeneoProducts\Models\Mapping;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class MappingResource extends Resource
{
    public static $model = Mapping::class;

    public static $title = 'source';

    public static $group = 'Akeneo Products';

    public static $search = [
        'source',
        'destination',
    ];

    public static function label(): string
    {
        return 'Mappings';
    }

    public static function uriKey(): string
    {
        return 'akeneo-products-mappings';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make(__('Type'), 'type')
                ->options(
                    collect(MappingType::cases())
                        ->mapWithKeys(fn (MappingType $type): array => [$type->value => __($type->name)])
                        ->toArray()
                )
                ->displayUsingLabels()
                ->rules('required')
                ->sortable(),

            Text::make(__('Source'), 'source')
                ->sortable(),

            Text::make(__('Destination'), 'destination')
                ->sortable(),

            Boolean::make(__('Override'), 'override')
                ->help(__('If this option is enabled, the source value will always override the value in the destination.'))
                ->sortable(),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            Filters\TypeFilter::make(),
        ];
    }
}
