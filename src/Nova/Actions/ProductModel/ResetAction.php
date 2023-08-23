<?php

namespace JustBetter\AkeneoProductsNova\Nova\Actions\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JustBetter\AkeneoProducts\Models\ProductModel;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class ResetAction extends Action
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $name = 'Reset Synchronization Status';

    public $confirmText = 'Reset the synchronization status to retrieve the product model and update the data in Akeneo again.';

    public $confirmButtonText = 'Reset';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(function (ProductModel $productModel): void {
            $productModel->synchronize = true;
            $productModel->retrieve = true;
            $productModel->update = false;
            $productModel->fail_count = 0;
            $productModel->failed_at = null;
            $productModel->save();
        });

        return ActionResponse::message(__('Reset!'));
    }
}
