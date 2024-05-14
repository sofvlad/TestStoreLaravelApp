<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AttributeRepository
{
    /**
     * Get the product attributes by type id.
     *
     * @param int $typeId
     * @param array $attributeFilters
     *
     * @return Collection
     */
    public function getListByTypeId(int $typeId)
    {
        return Attribute::whereHas('typeAttributes', function(Builder $q) use ($typeId) {
            $q->where('product_type_id', $typeId);
        })->get()->keyBy('id');
    }
}
