<?php

use App\Models\Product\Attribute;
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
        Schema::create('product_type_attributes', function (Blueprint $table) {
            $table->foreignId('product_attribute_id')->index();
            $table->foreignId('product_type_id')->index();
            $table->timestamps();

            $table->foreign('product_attribute_id')
                ->references('id')
                ->on(Attribute::TABLE_NAME)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('product_type_attributes');
    }
};
