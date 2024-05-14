<?php

use App\Models\Product;
use App\Models\Product\Attribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->foreignId('product_id')->index();
            $table->foreignId('product_attribute_id')->index();
            $table->string('value')->index();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on(Product::TABLE_NAME)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('product_attribute_id')
                ->references('id')
                ->on(Attribute::TABLE_NAME)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};
