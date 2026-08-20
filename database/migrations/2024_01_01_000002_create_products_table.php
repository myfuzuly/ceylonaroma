<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('products')) return;

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku', 60)->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('variants')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_unit', 30)->nullable();
            $table->string('currency', 5)->nullable();
            $table->decimal('min_order_qty', 10, 2)->nullable();
            $table->string('min_order_unit', 30)->nullable();
            $table->decimal('weight_per_unit', 10, 2)->nullable();
            $table->string('origin', 100)->nullable();
            $table->string('certifications')->nullable();
            $table->string('shelf_life', 100)->nullable();
            $table->integer('stock_qty')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_export_ready')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
