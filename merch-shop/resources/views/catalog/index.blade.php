<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
    <style>
        div span a svg, div span span svg {
            width: 10%;
            height: auto;
        }
    </style>
</head>
<body>
<div>
    <h2>Filters</h2>
    <form method="get">
        <div>
            <div>
                <label for="search_query">Search</label>
                <input type="text" name="search_query" id="search_query" value="{{ request('search_query') }}">
            </div>
            <div>
                <label for="sort_mode">Sort mode</label>
                <select name="sort_mode" id="sort_mode">
                    <option
                        value="price_asc"
                        {{ \App\Enums\ProductSortType::keyToValue(request('sort_mode')) === \App\Enums\ProductSortType::PRICE_ASC ? 'selected' : '' }}>
                        Price asc
                    </option>
                    <option
                        value="price_desc"
                        {{\App\Enums\ProductSortType::keyToValue(request('sort_mode')) === \App\Enums\ProductSortType::PRICE_DESC ? 'selected' : '' }}}>
                        Price desc
                    </option>
                </select>
            </div>
            <div>
                @foreach($filters as $filter)
                    <div>
                        <h4>{{ $filter->name }}</h4>
                        @foreach($filter->options as $option)
                            <label>
                                <input type="checkbox" value="{{ $option->value }}" name="filters[{{ $filter->key }}][]"
                                    {{ $option->isSelected ? 'checked' : '' }}>
                                {{ $option->value }} ({{ $option->productCount }})
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <button>Submit</button>
        </div>
    </form>
</div>
<h2>Catalog</h2>
@include('catalog.catalog_list', ['categories' => $categories])

@foreach($products as $product)
    <a href="{{ route('product', $product->slug) }}">
        <h3>{{ $product->name }}</h3>
    </a>
    <p>{{ $product->price }} rub.</p>
@endforeach
{{ $products->links() }}

</body>
</html>
