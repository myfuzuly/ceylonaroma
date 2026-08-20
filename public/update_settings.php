<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$settings = [
    'site_name'        => 'Ceylon Aroma Commodities',
    'company_name'     => 'Ceylon Aroma Commodities Exports (Private) Limited',
    'company_reg'      => 'PV 00257440',
    'address'          => 'No:F-05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka',
    'phone'            => '+94 354 341 234',
    'mobile'           => '+94 766 930 930',
    'email'            => 'info@ceylonaroma.com',
    'website'          => 'www.ceylonaroma.com',
    'tagline'          => 'Delivering the Natural Taste & Aroma of Sri Lanka to the World',
    'stat_countries'   => '60+',
    'stat_products'    => '500+',
    'stat_years'       => '15+',
    'meta_description' => 'Ceylon Aroma Commodities — premium Sri Lankan spices, teas, coffees, aromatic oils and natural products exported to 60+ countries worldwide.',
    'meta_keywords'    => 'Ceylon spices, Sri Lanka tea, Ceylon cinnamon, natural exports, Ceylon coffee, aromatic oils, Sri Lankan products',
];

foreach ($settings as $key => $value) {
    $exists = DB::table('settings')->where('key', $key)->exists();
    if ($exists) {
        DB::table('settings')->where('key', $key)->update(['value' => $value, 'updated_at' => now()]);
        echo "UPDATED: $key\n";
    } else {
        DB::table('settings')->insert(['key' => $key, 'value' => $value, 'created_at' => now(), 'updated_at' => now()]);
        echo "ADDED: $key\n";
    }
}
echo "\nDone. Settings updated.\n";
