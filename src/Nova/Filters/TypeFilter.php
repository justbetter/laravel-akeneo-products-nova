<?php

namespace JustBetter\AkeneoProductsNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use JustBetter\AkeneoProducts\Enums\MappingType;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class TypeFilter extends Filter
{
    public $name = 'Type';

    /** @param  Builder  $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('type', '=', $value);
    }

    public function options(NovaRequest $request): array
    {
        return collect(MappingType::cases())
            ->mapWithKeys(fn (MappingType $type): array => [__($type->name) => $type->value])
            ->toArray();
    }
}
