<?php
declare(strict_types=1);

namespace App\Models\Source\Product\Attribute;

use Illuminate\Contracts\Support\Arrayable;

class YesNo implements Arrayable
{
    public function toArray(): array
    {
        return [
            0  => 'Нет',
            1  => 'Да',
        ];
    }
}
