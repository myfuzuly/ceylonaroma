<?php
/* Create customers, orders, order_items — DELETE after use */
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('customers')) {
    Schema::create('customers', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->string('email')->unique();
        $t->string('password')->nullable();
        $t->string('phone', 50)->nullable()->unique();
        $t->string('company')->nullable();
        $t->string('country', 100)->nullable();
        $t->text('address')->nullable();
        $t->string('google_id')->nullable()->unique();
        $t->string('avatar')->nullable();
        $t->string('otp_code', 6)->nullable();
        $t->timestamp('otp_expires_at')->nullable();
        $t->string('remember_token', 100)->nullable();
        $t->timestamps();
    });
    echo "CREATED: customers<br>";
} else { echo "EXISTS: customers<br>"; }

if (!Schema::hasTable('orders')) {
    Schema::create('orders', function (Blueprint $t) {
        $t->id();
        $t->string('order_number', 20)->unique();
        $t->unsignedBigInteger('customer_id')->nullable()->index();
        $t->string('name');
        $t->string('email');
        $t->string('phone', 50)->nullable();
        $t->string('company')->nullable();
        $t->string('country', 100)->nullable();
        $t->text('address')->nullable();
        $t->text('notes')->nullable();
        $t->enum('status',['pending','confirmed','processing','shipped','delivered','cancelled'])->default('pending');
        $t->unsignedInteger('items_count')->default(0);
        $t->string('payment_method', 30)->nullable();
        $t->string('payment_status', 30)->nullable();
        $t->string('payment_id', 100)->nullable();
        $t->timestamps();
    });
    echo "CREATED: orders<br>";
} else { echo "EXISTS: orders<br>"; }

if (!Schema::hasTable('order_items')) {
    Schema::create('order_items', function (Blueprint $t) {
        $t->id();
        $t->foreignId('order_id')->constrained()->cascadeOnDelete();
        $t->unsignedBigInteger('product_id')->nullable();
        $t->string('product_name');
        $t->string('product_slug');
        $t->string('product_image')->nullable();
        $t->unsignedInteger('quantity')->default(1);
        $t->text('notes')->nullable();
        $t->timestamps();
    });
    echo "CREATED: order_items<br>";
} else { echo "EXISTS: order_items<br>"; }

echo "<br>Done.";
