<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductsFromCatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $resource
     * @return array
     */
    public static function collection($resource)
    {
        return tap(new ProductFromCatalogCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }
}
