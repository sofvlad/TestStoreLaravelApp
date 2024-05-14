<?php
declare(strict_types=1);

namespace App\Models\Product;

use App\Casts\Product\AttributeValue as AttributeValueCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    const TABLE_NAME = 'product_attribute_values';

    const CAST_VALUE_BY_ATTRIBUTE_TYPE = [
        Attribute::ATTRUBUTE_TYPE_INT    => 'intval',
        Attribute::ATTRUBUTE_TYPE_TEXT   => 'strval',
        Attribute::ATTRUBUTE_TYPE_BOOL   => 'boolval',
        Attribute::ATTRUBUTE_TYPE_FLOAT  => 'floatval',
        Attribute::ATTRUBUTE_TYPE_SELECT => 'strval',
    ];

    protected $primaryKey = null;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => AttributeValueCast::class,
        ];
    }

    /**
     * Get the product attribute values associated with the product attribute.
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'product_attribute_id');
    }
}
