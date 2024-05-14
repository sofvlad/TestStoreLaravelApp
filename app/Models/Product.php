<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Product\Attribute;
use App\Models\Product\AttributeValue;
use App\Models\Product\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    const TABLE_NAME = 'products';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'price',
        'final_price',
    ];

    /**
     * Get the attributes.
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'product_id');
    }

    /**
     * Get the attribute values.
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'product_id');
    }

    /**
     * Get the type.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'product_type_id');
    }
}
