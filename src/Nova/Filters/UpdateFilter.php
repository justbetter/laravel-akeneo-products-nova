<?php

namespace JustBetter\AkeneoProductsNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class UpdateFilter extends Filter
{
    public $name = 'Pending update';

    /** @param  Builder  $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('update', '=', $value);
    }

    public function options(NovaRequest $request): array
    {
        return [
            __('Yes') => 1,
            __('No') => 0,
        ];
    }
}
