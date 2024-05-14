<?php
declare(strict_types=1);

namespace App\Models\Source\Product\Attribute;

use Illuminate\Contracts\Support\Arrayable;

class Size implements Arrayable
{
    public function toArray(): array
    {
        $values = range(35, 49);

        return array_combine($values, $values);
    }
}
