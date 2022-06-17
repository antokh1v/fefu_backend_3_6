<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        svg{
            width:10%;
            height: auto;
        }
    </style>
    <title>Categories</title>
</head>
<body>
    Catalog
    @include('catalog.catalog_list', ['categories' => $categories])

    @foreach($products as $product)
        <article>
            <a href="{{ route('product', $product->slug) }}">
                <h3>{{ $product->name }}</h3>
            </a>
            <p>{{ $product->price }} руб.</p>
        </article>
    @endforeach
    {{ $products->links() }}
</body>
</html>
