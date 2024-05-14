<?php
declare(strict_types=1);

namespace App\Casts\Product;

use App\Models\Product\Attribute;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AttributeValue implements CastsAttributes
{
    const CAST_GET_BY_ATTRIBUTE_TYPE = [
        Attribute::ATTRUBUTE_TYPE_INT     => 'intval',
        Attribute::ATTRUBUTE_TYPE_TEXT    => 'strval',
        Attribute::ATTRUBUTE_TYPE_FLOAT   => 'floatval',
        Attribute::ATTRUBUTE_TYPE_SELECT  => 'strval',
    ];

    /**
     * @inheritDoc
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return $value;
        }
        $attribute = $model->attribute;
        if (!empty($attribute->option)) {
            $value = $attribute->getOptionValues()[$value];
        }
        if (!empty(self::CAST_GET_BY_ATTRIBUTE_TYPE[$attribute->type])) {
            $method = self::CAST_GET_BY_ATTRIBUTE_TYPE[$attribute->type];

            return $method($value);
        }
        if ($attribute->type == Attribute::ATTRUBUTE_TYPE_MULTISELECT) {
            return explode(',', $value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $attribute = $model->attribute;
        if ($attribute->type == Attribute::ATTRUBUTE_TYPE_BOOL) {
            return intval(is_string($value) && strtolower($value) === 'false' ? 0 : $value);
        }
        if (!empty($attribute->option)) {
            $value = array_search($value, $attribute->getOptionValues());
            if ($value === false) {
                throw new \Exception(sprintf(
                    'Error of set "%s" attribute value',
                    $attribute->code
                ));
            }
        }

        return $value;
        if ($attribute->type == Attribute::ATTRUBUTE_TYPE_MULTISELECT) {
            $value = !is_array($value) ? [$value] : $value;

            return implode(',', $value);
        }

        return !empty($attribute->option)
            ? array_search($value, app()->make($attribute->option)->toArray())
            : $value;
    }
}
