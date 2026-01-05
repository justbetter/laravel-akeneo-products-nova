<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions\Product;

use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveByIdentifier extends Action
{
    public function __construct()
    {
        $this->withName(__('Retrieve Product by Identifier'))
            ->standalone();
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $identifier = $fields->get('identifier');
        $csv = $fields->get('csv', false);

        if ($csv) {
            $identifiers = array_map('trim', explode(',', $identifier));

            foreach ($identifiers as $identifier) {
                if (! empty($identifier)) {
                    RetrieveProductJob::dispatch($identifier);
                }
            }

            return ActionResponse::message(__('Retrieving :count products', ['count' => count($identifiers)]));
        }

        RetrieveProductJob::dispatch($identifier);

        return ActionResponse::message(__('Retrieving :identifier', ['identifier' => $identifier]));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('Identifier'), 'identifier')
                ->required(),

            Boolean::make(__('CSV'), 'csv')
                ->help(__('Check this if you are providing a comma-separated list of identifiers. i.e.: identifier1,identifier2')),
        ];
    }
}
