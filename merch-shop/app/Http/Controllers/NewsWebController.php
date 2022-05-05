<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class NewsWebController extends Controller
{
    public function index(Request $request)
    {
        $news_list = News::query()
            ->published()
            ->orderBy('published_at')
            ->paginate(10);
        return view('news_list', ['news_list' => $news_list]);
    }

    public function show(Request $request, string $slug)
    {
        $news = News::query()
            ->published()
            ->where('slug', $slug)
            ->first();
        if ($news === null)
            abort(404);
        return view('news', ['news' => $news]);
    }
}
