<?php

namespace JustBetter\AkeneoProductsNova\Nova\Lenses;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProductsNova\Nova\Filters\RetrieveFilter;
use JustBetter\AkeneoProductsNova\Nova\Filters\SynchronizeFilter;
use JustBetter\AkeneoProductsNova\Nova\Filters\UpdateFilter;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class ProductLastErrorsLens extends Lens
{
    public function name(): string
    {
        return __('Last Errors');
    }

    public static function query(LensRequest $request, $query): EloquentBuilder
    {
        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
                ->join('activity_log', function (JoinClause $join) {
                    $join
                        ->on('activity_log.subject_id', '=', 'akeneo_products.id')
                        ->where('log_name', '=', 'error')
                        ->where('subject_type', '=', Product::class)
                        ->where('activity_log.id', '=', function (Builder $builder) {
                            $builder
                                ->selectRaw('MAX(id)')
                                ->from('activity_log')
                                ->where('subject_type', '=', Product::class)
                                ->where('subject_id', '=', DB::raw('akeneo_products.id'))
                                ->groupBy('subject_id');
                        });
                })
                ->orderByDesc('activity_log.created_at')
        ));
    }

    protected static function columns(): array
    {
        return [
            'akeneo_products.*',
            'activity_log.description',
            'activity_log.created_at',
        ];
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('Identifier'), 'identifier'),

            Text::make(
                __('Last Activity'),
                fn (Model $resource) => $resource->description ?? ''
            ),

            DateTime::make(
                __('Last Activity Date'),
                fn (Model $resource) => $resource->created_at
            ),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            RetrieveFilter::make(),
            UpdateFilter::make(),
            SynchronizeFilter::make(),
        ];
    }

    public function uriKey(): string
    {
        return 'akeneo-products-last-errors';
    }
}
