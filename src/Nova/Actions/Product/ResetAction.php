<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Models\Product;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class ResetAction extends Action
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $name = 'Reset Synchronization Status';

    public $confirmText = 'Reset the synchronization status to retrieve the product and update the data in Akeneo again.';

    public $confirmButtonText = 'Reset';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(function (Product $product): void {
            $product->synchronize = true;
            $product->retrieve = true;
            $product->update = false;
            $product->fail_count = 0;
            $product->failed_at = null;
            $product->save();
        });

        return ActionResponse::message(__('Reset!'));
    }
}
