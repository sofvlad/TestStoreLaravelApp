<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * Get the products by type id.
     *
     * @param int $typeId
     * @param array $attributeFilters
     *
     * @return Collection
     */
    public function getListByTypeId(int $typeId, ?array $attributeFilters = null, $pageSize = 40): AbstractPaginator
    {
        $products = Product::where('product_type_id', $typeId)
            ->orderBy('id');
        if (empty($attributeFilters)) {
            return $products->paginate($pageSize);
        }
        if (!empty($attributeFilters['search'])) {
            $products->where(function ($query) use ($attributeFilters) {
                $query->where('name', 'like', '%' . $attributeFilters['search'] . '%')
                      ->orWhere('sku', '=', '%' . $attributeFilters['search'] . '%');
            });
        }
        unset($attributeFilters['search']);
        if (!empty($attributeFilters['price'])) {
            if (!empty($attributeFilters['price']['from'])) {
                $products->where('final_price', '>=', $attributeFilters['price']['from']);
            }
            if (!empty($attributeFilters['price']['to'])) {
                $products->where('final_price', '<=', $attributeFilters['price']['to']);
            }
        }
        unset($attributeFilters['price']);
        if (empty($attributeFilters)) {
            return $products->paginate($pageSize);
        }

        $products->whereHas('attributeValues', function(Builder $query) use ($attributeFilters) {
            $query;
            $query->join(
                    Attribute::TABLE_NAME,
                    Attribute::TABLE_NAME . '.id',
                    AttributeValue::TABLE_NAME . '.product_attribute_id'
                )
                ->getQuery()
                ->select(['product_id', DB::raw('count(*) as attributes')])
                ->groupBy('product_id')
                ->having(DB::raw('count(*)'), '=', count($attributeFilters));
            $query->where(function ($q) use ($attributeFilters) {
                foreach ($attributeFilters as $attributeCode => $attributeValue) {
                    $q->orWhere(function ($q) use ($attributeCode, $attributeValue) {
                        $q->where(Attribute::TABLE_NAME . '.code', $attributeCode);
                        if (is_array($attributeValue)) {
                            if (array_key_exists('from', $attributeValue) || array_key_exists('to', $attributeValue)) {
                                if (!empty($attributeValue['from'])) {
                                    $q->where(AttributeValue::TABLE_NAME . '.value', '>=', $attributeValue['from']);
                                }
                                if (!empty($attributeValue['to'])) {
                                    $q->where(AttributeValue::TABLE_NAME . '.value', '<=', $attributeValue['to']);
                                }

                                return;
                            }
                            $q->whereIn(AttributeValue::TABLE_NAME . '.value', $attributeValue);

                            return;
                        }
                        $q->where(AttributeValue::TABLE_NAME . '.value', $attributeValue);
                    });
                }
            });
        });

        return $products->paginate($pageSize);
    }
}
