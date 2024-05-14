<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
    @if (count($products))
    @foreach ($products as $product)
        @include('catalog.product', ['product' => $product, 'attributes' => $attributes])
    @endforeach
    @else
    <p class="text-center fs-3">Продукты не найдены</p>
    @endif
</div>
@if (count($products))
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    {{ $products->withQueryString()->links() }}
</div>
@endif
