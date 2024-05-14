<?php
declare(strict_types=1);

namespace App\Models\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    const TABLE_NAME = 'product_types';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Get the product type attributes.
     */
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            TypeAttribute::TABLE_NAME,
            'product_type_id',
            'product_attribute_id'
        );
    }

    /**
     * Get the products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }
}
