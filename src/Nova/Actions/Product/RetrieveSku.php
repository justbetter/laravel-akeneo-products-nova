<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions\Product;

use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveSku extends Action
{
    public function __construct()
    {
        $this->withName(__('Retrieve Product by SKU'))
            ->standalone();
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $sku = $fields->get('sku');

        RetrieveProductJob::dispatch($sku);

        return ActionResponse::message(__('Retrieving :sku', ['sku' => $sku]));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('SKU'), 'sku')
                ->required(),
        ];
    }
}
