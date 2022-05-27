<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CatalogWebController extends Controller
{
    /**
     * Display catalog.
     *
     * @return Application|Factory|View
     */
    public function index(string $slug = null): View|Factory|Application
    {
        $query = ProductCategory::query()->with('children');

        if ($slug == null){
            $query->where('parent_id');
        } else{
            $query->where('slug', $slug);
        }
        return view('catalog.catalog', ['categories' => $query->get()]);
    }

}
