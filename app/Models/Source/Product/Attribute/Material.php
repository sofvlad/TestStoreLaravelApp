<?php
declare(strict_types=1);

namespace App\Models\Source\Product\Attribute;

use Illuminate\Contracts\Support\Arrayable;

class Material implements Arrayable
{
    public function toArray(): array
    {
        return [
            'textiles'  => 'Текстиль',
            'polyester' => 'Полиэстер',
            's_leather' => 'Синтетическая кожа',
            'r_leather' => 'Натуральная кожа',
        ];
    }
}
