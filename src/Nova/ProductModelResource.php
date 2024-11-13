<?php

namespace JustBetter\AkeneoProductsNova\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use JustBetter\AkeneoProducts\Models\ProductModel;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class ProductModelResource extends Resource
{
    public static $model = ProductModel::class;

    public static $title = 'code';

    public static $group = 'Akeneo Products';

    public static $search = [
        'code',
    ];

    public static function label(): string
    {
        return __('Product Models');
    }

    public static function uriKey(): string
    {
        return 'akeneo-products-product-models';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('Code'), 'code')
                ->sortable(),

            Boolean::make(__('Synchronize'), 'synchronize')
                ->help(__('Determines if the product model should be synchronized.'))
                ->sortable(),

            Boolean::make(__('Retrieve'), 'retrieve')
                ->help(__('Determines if the product model should be retrieved.'))
                ->sortable(),

            Boolean::make(__('Update'), 'update')
                ->help(__('Determines if the product model should be updated.'))
                ->sortable(),

            Code::make(__('Data'), 'data')
                ->json(),

            DateTime::make(__('Retrieved At'), 'retrieved_at')
                ->help(__('Last date the product model has been retrieved.'))
                ->sortable(),

            DateTime::make(__('Updated At'), 'modified_at')
                ->help(__('Last date the product model has been updated.'))
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
            Actions\ProductModel\RetrieveAction::make(),
            Actions\ProductModel\UpdateAction::make(),
            Actions\ProductModel\ResetAction::make(),
        ];
    }

    public function lenses(NovaRequest $request): array
    {
        return [
            Lenses\ProductModelLastErrorsLens::make(),
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
