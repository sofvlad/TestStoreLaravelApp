<?php
declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attribute extends Model
{
    use HasFactory;

    const TABLE_NAME = 'product_attributes';

    const ATTRUBUTE_TYPE_INT         = 'int';
    const ATTRUBUTE_TYPE_TEXT        = 'text';
    const ATTRUBUTE_TYPE_BOOL        = 'bool';
    const ATTRUBUTE_TYPE_FLOAT       = 'float';
    const ATTRUBUTE_TYPE_SELECT      = 'select';
    const ATTRUBUTE_TYPE_MULTISELECT = 'multiselect';

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
        'code',
        'name',
        'type',
        'default_value',
        'option',
    ];

    /**
     * Get the product attribute values associated with the product attribute.
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'product_attribute_id');
    }

    /**
     * Get the product type attributes.
     */
    public function typeAttributes(): HasMany
    {
        return $this->hasMany(TypeAttribute::class, 'product_attribute_id');
    }

    /**
     * Get option values
     *
     * @return array
     */
    public function getOptionValues(): array
    {
        if (empty($this->option)) {
            return [];
        }

        return app()->make($this->option)->toArray();
    }
}
