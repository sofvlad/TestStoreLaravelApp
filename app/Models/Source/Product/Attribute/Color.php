<?php
declare(strict_types=1);

namespace App\Models\Source\Product\Attribute;

use Illuminate\Contracts\Support\Arrayable;

class Color implements Arrayable
{
    public function toArray(): array
    {
        return [
            'red'   => 'Красный',
            'blue'  => 'Синий',
            'green' => 'Зелёный',
        ];
    }
}
