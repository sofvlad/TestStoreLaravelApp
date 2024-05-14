<div class="col mb-5">
    <div class="card h-100">
        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder">{{ $product->name }}</h5>
                @if ($product->price != $product->final_price)
                <span class="text-muted text-decoration-line-through">{{ $product->price }} руб.</span>
                @endif
                {{ $product->final_price }} руб.
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
            <button type="button" class="btn btn-outline-dark mt-auto" data-bs-toggle="modal" data-bs-target="#product-{{ $product->sku }}">
                Подробнее
            </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="product-{{ $product->sku }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $product->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card h-100">
                    <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                    <div class="card-body p-4">
                        <div class="text-left">
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            @if ($product->price != $product->final_price)
                            <span class="text-muted text-decoration-line-through">{{ $product->price }} руб.</span>
                            @endif
                            {{ $product->final_price }} руб.
                            <div class="mt-3">
                            @foreach ($product->attributeValues as $attributeValue)
                            <p class="mb-0"><span class="fw-semibold">{{ $attributes->get($attributeValue->product_attribute_id)->name }}:</span> {{ $attributeValue->value }}</p>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
