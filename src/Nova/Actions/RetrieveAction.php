<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Models\Product;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class RetrieveAction extends Action
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $name = 'Retrieve Product';

    public $confirmText = 'Mark the product to retrieve its data again.';

    public $confirmButtonText = 'Retrieve';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(function (Product $product): void {
            $product->retrieve = true;
            $product->save();
        });

        return ActionResponse::message(__('Marked!'));
    }
}
