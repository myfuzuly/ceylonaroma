<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
                $table->string('name');
                $table->string('email');
                $table->string('phone', 30)->nullable();
                $table->string('company', 100)->nullable();
                $table->string('country', 100)->nullable();
                $table->text('address')->nullable();
                $table->text('notes')->nullable();
                $table->string('status', 30)->default('pending');
                $table->unsignedInteger('items_count')->default(0);
                $table->string('payment_method', 30)->nullable();
                $table->string('payment_status', 30)->default('pending');
                $table->string('payment_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
                $table->string('product_name');
                $table->string('variant')->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->string('currency', 5)->default('USD');
                $table->unsignedInteger('quantity')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
