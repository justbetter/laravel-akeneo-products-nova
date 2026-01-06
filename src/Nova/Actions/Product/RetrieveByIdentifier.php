<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions\Product;

use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
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
        $rawIdentifiers = (string) $fields->get('identifiers', '');

        $identifiers = collect(explode(PHP_EOL, $rawIdentifiers))
            ->map(fn (string $identifier): string => trim($identifier))
            ->filter()
            ->unique()
            ->values();

        if ($identifiers->isEmpty()) {
            return ActionResponse::danger(__('No identifiers provided.'));
        }

        $identifiers->each(static function ($identifier): void {
            RetrieveProductJob::dispatch($identifier);
        });

        if ($identifiers->count() === 1) {
            return ActionResponse::message(__('Retrieving :identifier', ['identifier' => $identifiers->first()]));
        }

        return ActionResponse::message(__('Retrieving :count products', ['count' => $identifiers->count()]));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make(__('Identifiers'), 'identifiers')
                ->required()
                ->help(__('Enter one identifier per line.')),
        ];
    }
}
