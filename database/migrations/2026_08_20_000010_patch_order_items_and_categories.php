<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // order_items: add columns that were added via deploy scripts
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'product_slug')) {
                $table->string('product_slug')->nullable()->after('product_name');
            }
            if (!Schema::hasColumn('order_items', 'product_image')) {
                $table->string('product_image')->nullable()->after('product_slug');
            }
            if (!Schema::hasColumn('order_items', 'notes')) {
                $table->text('notes')->nullable()->after('quantity');
            }
        });

        // categories: add parent_id for subcategory support
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumnIfExists('product_slug');
            $table->dropColumnIfExists('product_image');
            $table->dropColumnIfExists('notes');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumnIfExists('parent_id');
        });
    }
};
