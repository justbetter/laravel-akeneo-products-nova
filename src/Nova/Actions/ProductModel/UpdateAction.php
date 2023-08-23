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

class UpdateAction extends Action
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $name = 'Update Product Model';

    public $confirmText = 'Mark the product model to update the data in Akeneo.';

    public $confirmButtonText = 'Update';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(function (ProductModel $productModel): void {
            $productModel->retrieve = false;
            $productModel->update = true;
            $productModel->save();
        });

        return ActionResponse::message(__('Marked!'));
    }
}
