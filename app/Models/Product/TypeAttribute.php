<?php
declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeAttribute extends Model
{
    use HasFactory;

    const TABLE_NAME = 'product_type_attributes';

    protected $primaryKey = null;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Get the product attribute.
     */
    public function attribute(): HasOne
    {
        return $this->hasOne(Attribute::class, 'product_attribute_id');
    }

    /**
     * Get the product type.
     */
    public function type(): HasOne
    {
        return $this->hasOne(Type::class, 'product_type_id');
    }
}
