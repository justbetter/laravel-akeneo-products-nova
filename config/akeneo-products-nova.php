<?php

use JustBetter\AkeneoProductsNova\Nova\MappingResource;
use JustBetter\AkeneoProductsNova\Nova\ProductModelResource;
use JustBetter\AkeneoProductsNova\Nova\ProductResource;

return [

    /* Resources that will be registered by the package. */
    'resources' => [
        MappingResource::class,
        ProductResource::class,
        ProductModelResource::class,
    ],

];
