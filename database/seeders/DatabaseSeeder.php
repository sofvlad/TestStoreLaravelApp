<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeValue;
use App\Models\Product\Type;
use App\Models\Product\TypeAttribute;
use App\Models\Source\Product\Attribute\Color;
use App\Models\Source\Product\Attribute\Material;
use App\Models\Source\Product\Attribute\Size;
use App\Models\Source\Product\Attribute\YesNo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \Illuminate\Support\Facades\DB::table('products')->truncate();
        \Illuminate\Support\Facades\DB::table('product_types')->truncate();
        \Illuminate\Support\Facades\DB::table('product_type_attributes')->truncate();
        \Illuminate\Support\Facades\DB::table('product_attributes')->truncate();
        \Illuminate\Support\Facades\DB::table('product_attribute_values')->truncate();

        $productType = Type::factory()->create([
            'code' => 'sneakers',
            'name' => 'Кроссовки',
        ]);

        $productAttributes = Attribute::factory()
            ->count(4)
            ->sequence(
                [
                    'code'   => 'color',
                    'name'   => 'Цвет',
                    'type'   => Attribute::ATTRUBUTE_TYPE_TEXT,
                    'option' => Color::class,
                ],
                [
                    'code'   => 'material',
                    'name'   => 'Материал',
                    'type'   => Attribute::ATTRUBUTE_TYPE_TEXT,
                    'option' => Material::class,
                ],
                [
                    'code'   => 'size',
                    'name'   => 'Размер',
                    'type'   => Attribute::ATTRUBUTE_TYPE_INT,
                    'option' => Size::class,
                ],
                [
                    'code'          => 'premium',
                    'name'          => 'Премиум',
                    'type'          => Attribute::ATTRUBUTE_TYPE_BOOL,
                    'option'        => YesNo::class,
                    'default_value' => 0,
                ],
            )->create();

        foreach ($productAttributes as $productAttribute) {
            TypeAttribute::factory()
                ->create([
                    'product_attribute_id' => $productAttribute->id,
                    'product_type_id'      => $productType->id,
                ]);
        }

        $productsCount = 100;
        $productsIndex = 1;
        while ($productsIndex <= $productsCount) {
            $price = rand(10, 100) * 100;
            $product = Product::factory()
                ->sequence([
                    'name'            => 'Кроссовки ' . $productsIndex++,
                    'sku'             => fake()->bothify('??-####'),
                    'price'           => $price,
                    'final_price'     => rand(0, 4) < 4 ? $price : $price * (rand(5, 9) / 10),
                    'product_type_id' => $productType->id,
                ])
                ->create();

            $attributeValues = [];
            foreach ($productAttributes as $productAttribute) {
                switch ($productAttribute->code) {
                    case 'color':
                    case 'material':
                    case 'size':
                        $options = $productAttribute->getOptionValues();
                        $attributeValues[] = [
                            'product_id'           => $product->id,
                            'product_attribute_id' => $productAttribute->id,
                            'value'                => $options[array_rand($options)],
                        ];
                        break;
                    case 'premium':
                        $attributeValues[] = [
                            'product_id'           => $product->id,
                            'product_attribute_id' => $productAttribute->id,
                            'value'                => (int)($product->price >= 8000),
                        ];
                        break;
                    default:
                        throw new \Exception(sprintf(
                            'Test data for "%s" product attribute is not implemented',
                            $productAttribute->code
                        ));
                }
            }

            AttributeValue::factory()
                ->count(count($productAttributes))
                ->sequence(...$attributeValues)
                ->create();
        }
    }
}
