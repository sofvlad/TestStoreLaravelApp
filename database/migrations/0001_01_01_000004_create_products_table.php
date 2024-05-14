<?php

use App\Models\Product\Type;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('sku')->unique()->index();
            $table->double('price', 8, 2);
            $table->double('final_price', 8, 2);
            $table->foreignId('product_type_id')->index();
            $table->timestamps();

            $table->foreign('product_type_id')
                ->references('id')
                ->on(Type::TABLE_NAME)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
