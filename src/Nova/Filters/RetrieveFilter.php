<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProductsNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveFilter extends Filter
{
    public $name = 'Pending retrieve';

    /** @param  Builder  $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('retrieve', '=', $value);
    }

    #[\Override]
    public function options(NovaRequest $request): array
    {
        return [
            __('Yes') => 1,
            __('No') => 0,
        ];
    }
}
