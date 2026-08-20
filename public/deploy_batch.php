<?php
$base = dirname(__DIR__);
$jobs = [
    /* CSS */
    __DIR__ . '/app-css9.css.gz'           => $base . '/ceylon_aroma/resources/css/app-css9.css',
    __DIR__ . '/app-css10.css.gz'          => $base . '/ceylon_aroma/resources/css/app-css10.css',
    __DIR__ . '/css.php.gz'                => $base . '/public_html/css.php',

    /* Home views */
    __DIR__ . '/home_p1.blade.php.gz'      => $base . '/ceylon_aroma/resources/views/home-p1.blade.php',
    __DIR__ . '/home_p2.blade.php.gz'      => $base . '/ceylon_aroma/resources/views/home-p2.blade.php',
    __DIR__ . '/home_p3.blade.php.gz'      => $base . '/ceylon_aroma/resources/views/home-p3.blade.php',

    /* Layouts */
    __DIR__ . '/app_top.blade.php.gz'         => $base . '/ceylon_aroma/resources/views/layouts/app-top.blade.php',
    __DIR__ . '/app_foot.blade.php.gz'        => $base . '/ceylon_aroma/resources/views/layouts/app-foot.blade.php',
    __DIR__ . '/admin_layout.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/layouts/admin.blade.php',

    /* Partials */
    __DIR__ . '/product_card.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/partials/product-card.blade.php',

    /* Models */
    __DIR__ . '/Product.php.gz'               => $base . '/ceylon_aroma/app/Models/Product.php',
    __DIR__ . '/Order.php.gz'                 => $base . '/ceylon_aroma/app/Models/Order.php',
    __DIR__ . '/Customer.php.gz'              => $base . '/ceylon_aroma/app/Models/Customer.php',
    __DIR__ . '/OrderItem.php.gz'             => $base . '/ceylon_aroma/app/Models/OrderItem.php',

    /* Middleware */
    __DIR__ . '/CustomerAuth.php.gz'          => $base . '/ceylon_aroma/app/Http/Middleware/CustomerAuth.php',

    /* Services */
    __DIR__ . '/SmsService.php.gz'            => $base . '/ceylon_aroma/app/Services/SmsService.php',

    /* Controllers - Admin */
    __DIR__ . '/AdminProductCtrl.php.gz'      => $base . '/ceylon_aroma/app/Http/Controllers/Admin/ProductController.php',
    __DIR__ . '/DashboardCtrl.php.gz'         => $base . '/ceylon_aroma/app/Http/Controllers/Admin/DashboardController.php',
    __DIR__ . '/AdminCustomerCtrl.php.gz'     => $base . '/ceylon_aroma/app/Http/Controllers/Admin/CustomerController.php',
    __DIR__ . '/admin_order_ctrl.php.gz'      => $base . '/ceylon_aroma/app/Http/Controllers/Admin/OrderController.php',
    __DIR__ . '/CategoryController.php.gz'    => $base . '/ceylon_aroma/app/Http/Controllers/Admin/CategoryController.php',

    /* Controllers - Frontend */
    __DIR__ . '/InquiryController.php.gz'     => $base . '/ceylon_aroma/app/Http/Controllers/InquiryController.php',
    __DIR__ . '/CustomerAuthCtrl.php.gz'      => $base . '/ceylon_aroma/app/Http/Controllers/CustomerAuthController.php',
    __DIR__ . '/CustomerCtrl.php.gz'          => $base . '/ceylon_aroma/app/Http/Controllers/CustomerController.php',
    __DIR__ . '/CartCtrl.php.gz'              => $base . '/ceylon_aroma/app/Http/Controllers/CartController.php',
    __DIR__ . '/OrderCtrl.php.gz'             => $base . '/ceylon_aroma/app/Http/Controllers/OrderController.php',
    __DIR__ . '/PayHereCtrl.php.gz'           => $base . '/ceylon_aroma/app/Http/Controllers/PayHereController.php',

    /* Admin views */
    __DIR__ . '/dash_index.blade.php.gz'         => $base . '/ceylon_aroma/resources/views/admin/dashboard/index.blade.php',
    __DIR__ . '/prod_admin_index.blade.php.gz'   => $base . '/ceylon_aroma/resources/views/admin/products/index.blade.php',
    __DIR__ . '/prod_fields.blade.php.gz'        => $base . '/ceylon_aroma/resources/views/admin/products/_fields.blade.php',
    __DIR__ . '/cat_index.blade.php.gz'          => $base . '/ceylon_aroma/resources/views/admin/categories/index.blade.php',
    __DIR__ . '/cat_form.blade.php.gz'           => $base . '/ceylon_aroma/resources/views/admin/categories/form.blade.php',
    __DIR__ . '/cust_admin_index.blade.php.gz'   => $base . '/ceylon_aroma/resources/views/admin/customers/index.blade.php',
    __DIR__ . '/cust_admin_show.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/admin/customers/show.blade.php',
    __DIR__ . '/admin_order_idx.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/admin/orders/index.blade.php',
    __DIR__ . '/admin_order_show.blade.php.gz'   => $base . '/ceylon_aroma/resources/views/admin/orders/show.blade.php',

    /* Pages */
    __DIR__ . '/contact.blade.php.gz'            => $base . '/ceylon_aroma/resources/views/pages/contact.blade.php',
    __DIR__ . '/about.blade.php.gz'              => $base . '/ceylon_aroma/resources/views/pages/about.blade.php',

    /* Frontend views */
    __DIR__ . '/prod_show.blade.php.gz'          => $base . '/ceylon_aroma/resources/views/products/show.blade.php',
    __DIR__ . '/cust_login.blade.php.gz'         => $base . '/ceylon_aroma/resources/views/customer/login.blade.php',
    __DIR__ . '/cust_register.blade.php.gz'      => $base . '/ceylon_aroma/resources/views/customer/register.blade.php',
    __DIR__ . '/cust_otp_phone.blade.php.gz'     => $base . '/ceylon_aroma/resources/views/customer/otp-phone.blade.php',
    __DIR__ . '/cust_otp_verify.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/customer/otp-verify.blade.php',
    __DIR__ . '/cust_dashboard.blade.php.gz'     => $base . '/ceylon_aroma/resources/views/customer/dashboard.blade.php',
    __DIR__ . '/cust_orders.blade.php.gz'        => $base . '/ceylon_aroma/resources/views/customer/orders.blade.php',
    __DIR__ . '/cust_order_show.blade.php.gz'    => $base . '/ceylon_aroma/resources/views/customer/order-show.blade.php',
    __DIR__ . '/cust_profile.blade.php.gz'       => $base . '/ceylon_aroma/resources/views/customer/profile.blade.php',
    __DIR__ . '/cust_sidebar.blade.php.gz'       => $base . '/ceylon_aroma/resources/views/customer/partials/sidebar.blade.php',
    __DIR__ . '/cart.blade.php.gz'               => $base . '/ceylon_aroma/resources/views/cart.blade.php',
    __DIR__ . '/checkout.blade.php.gz'           => $base . '/ceylon_aroma/resources/views/checkout.blade.php',
    __DIR__ . '/order_confirm.blade.php.gz'      => $base . '/ceylon_aroma/resources/views/order-confirmation.blade.php',

    /* Routes & bootstrap */
    __DIR__ . '/web.php.gz'                      => $base . '/ceylon_aroma/routes/web.php',
    __DIR__ . '/bootstrap_app.php.gz'            => $base . '/ceylon_aroma/bootstrap/app.php',
    __DIR__ . '/AppServiceProvider.php.gz'       => $base . '/ceylon_aroma/app/Providers/AppServiceProvider.php',

    /* Image chunk scripts → public_html (run in order after deploy) */
    __DIR__ . '/img_chunk1.php.gz'               => $base . '/public_html/img_chunk1.php',
    __DIR__ . '/img_chunk2.php.gz'               => $base . '/public_html/img_chunk2.php',
    __DIR__ . '/img_chunk3.php.gz'               => $base . '/public_html/img_chunk3.php',
];

foreach ($jobs as $gz => $target) {
    if (!file_exists($gz)) { echo "SKIP: " . basename($gz) . "<br>"; continue; }
    $dir = dirname($target);
    if (!is_dir($dir)) { mkdir($dir, 0755, true); }
    $c = file_get_contents("compress.zlib://$gz");
    if ($c === false) { echo "FAIL decompress: $gz<br>"; continue; }
    if (file_put_contents($target, $c) === false) { echo "FAIL write: $target<br>"; continue; }
    unlink($gz);
    echo "OK: " . strlen($c) . "B → " . basename($target) . "<br>";
}
echo "<br><strong>Done.</strong>";
