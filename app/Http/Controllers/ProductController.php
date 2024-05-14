<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AttributeRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        AttributeRepository $attributeRepository,
        ProductRepository $productRepository,
        Request $request
    ): View {
        return view('catalog', [
            'attributes' => $attributeRepository->getListByTypeId(1),
            'products'   => $productRepository->getListByTypeId(1, $request->get('filters')),
        ]);
    }
}
