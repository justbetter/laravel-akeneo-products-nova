<?php

namespace JustBetter\AkeneoProductsNova\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use JustBetter\AkeneoProducts\Models\Product;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class ProductResource extends Resource
{
    public static $model = Product::class;

    public static $title = 'identifier';

    public static $group = 'Akeneo Products';

    public static $search = [
        'identifier',
    ];

    public static function label(): string
    {
        return __('Products');
    }

    public static function uriKey(): string
    {
        return 'akeneo-products-products';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('Identifier'), 'identifier')
                ->sortable(),

            Boolean::make(__('Synchronize'), 'synchronize')
                ->help(__('Determines if the product should be synchronized.'))
                ->sortable(),

            Boolean::make(__('Retrieve'), 'retrieve')
                ->help(__('Determines if the product should be retrieved.'))
                ->sortable(),

            Boolean::make(__('Update'), 'update')
                ->help(__('Determines if the product should be updated.'))
                ->sortable(),

            Code::make(__('Data'), 'data')
                ->json(),

            Number::make(__('Fail Count'), 'fail_count')
                ->hideFromIndex(),

            DateTime::make(__('Retrieved At'), 'retrieved_at')
                ->help(__('Last date the product has been retrieved.'))
                ->sortable(),

            DateTime::make(__('Updated At'), 'modified_at')
                ->help(__('Last date the product has been updated.'))
                ->sortable(),

            MorphMany::make(__('Activity'), 'activities', Activitylog::class),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            Filters\RetrieveFilter::make(),
            Filters\UpdateFilter::make(),
            Filters\SynchronizeFilter::make(),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            Actions\Product\RetrieveAction::make(),
            Actions\Product\UpdateAction::make(),
            Actions\Product\ResetAction::make(),
        ];
    }

    public function lenses(NovaRequest $request): array
    {
        return [
            Lenses\ProductLastErrorsLens::make(),
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return false;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }
}
