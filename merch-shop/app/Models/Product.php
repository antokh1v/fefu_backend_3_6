<?php

namespace App\Models;

use App\Enums\ProductSortType;
use App\Http\Filters\ProductFilter;
use Cviebrock\EloquentSluggable\Sluggable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function sortedAttributeValues(): HasMany
    {
        return $this
            ->attributeValues()
            ->join('product_attributes', 'product_attributes.id', '=', 'product_attribute_values.product_attribute_id')
            ->orderBy('product_attributes.sort_order')
            ->orderBy('product_attributes.id');
    }

    public function scopeSearch(Builder $builder, string $search_query): Builder
    {
        return $builder->where('products.name', 'ilike', "%$search_query%");
    }

    /**
     * @throws Exception
     */
    public static function findProducts(array $requestData)
    {

        $slug = $requestData['slug'] ?? null;

        $categoryQuery = ProductCategory::query()
            ->with('children', 'products');
        if ($slug === null) {
            $categoryQuery->where('parent_id');
        } else {
            $categoryQuery->where('slug', $slug);
        }
        $categories = $categoryQuery->get();
        $productQuery = ProductCategory::getTreeProductsBuilder($categories);
        $appliedFilters = $requestData['filters'] ?? [];
        $filters = ProductFilter::build($productQuery, $appliedFilters);
        ProductFilter::apply($productQuery, $appliedFilters);

        $searchQuery = $requestData['search_query'] ?? null;
        if ($searchQuery) {
            $productQuery->search($searchQuery);
        }

        $sortMode = $requestData['sort_mode'] ?? null;
        if ($sortMode === ProductSortType::PRICE_ASC) {
            $productQuery->orderBy('price', 'asc');

        } else if ($sortMode === ProductSortType::PRICE_DESC) {
            $productQuery->orderBy('price', 'desc');
        }


        return [
            'product_query' => $productQuery,
            'filters' => $filters,
            'categories' => $categories,
            'key_params' => [
                'category_slug' => $slug,
                'search_query' => $searchQuery,
                'filters' => $appliedFilters,
                'sort_mode' => $sortMode
            ]
        ];
    }
}
