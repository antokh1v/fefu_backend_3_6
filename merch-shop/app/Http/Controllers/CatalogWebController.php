<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogFormRequest;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Throwable;

class CatalogWebController extends Controller
{
    /**
     * Display catalog.
     *
     * @param CatalogFormRequest $request
     * @param string|null $slug
     * @return Application|Factory|View
     */
    public function index(CatalogFormRequest $request, string $slug = null): View|Factory|Application
    {
        $requestData = $request->validated();
        $requestData['slug'] = $slug;
        try {
            $data = Product::findProducts($requestData);
        } catch (Throwable $e) {
            abort(422, $e->getMessage());
        }
        return view('catalog.index', [
            'categories' => $data['categories'],
            'products' => $data['product_query']->orderBy('products.id')->paginate()->appends([
                'category_slug' => $data['key_params']['category_slug'],
                'search_query' => $data['key_params']['search_query'],
                'filters' => $data['key_params']['filters'],
                'sort_mode' => $data['key_params']['sort_mode'],
            ]),
            'filters' => $data['filters'],
        ]);
    }

}
