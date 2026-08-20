<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{Category, Product, Collection, BlogPost, Setting};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        \App\Models\User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@ceylonaroma.com')],
            ['name' => 'Administrator', 'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@2024')), 'role' => 'admin']
        );

        // Settings
        $settings = [
            'site_name'       => 'Ceylon Aroma',
            'site_tagline'    => 'Natural · Pure · Ceylon',
            'site_email'      => 'info@ceylonaroma.com',
            'site_phone'      => '+94 77 123 4567',
            'site_address'    => 'No: F – 05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka',
            'stat_countries'  => '60+',
            'stat_products'   => '500+',
            'stat_years'      => '15+',
            'facebook_url'    => '#',
            'instagram_url'   => '#',
            'linkedin_url'    => '#',
            'youtube_url'     => '#',
            'meta_description'=> 'Premium quality spices, tea, coffee, oils and natural products exported from Sri Lanka.',
        ];
        foreach ($settings as $k => $v) Setting::set($k, $v);

        // Categories
        $cats = [
            ['name'=>'Ceylon Spices',           'slug'=>'ceylon-spices',           'sort_order'=>1],
            ['name'=>'Ceylon Coffee',           'slug'=>'ceylon-coffee',           'sort_order'=>2],
            ['name'=>'Ceylon Tea',              'slug'=>'ceylon-tea',              'sort_order'=>3],
            ['name'=>'Aromatic Oils',           'slug'=>'aromatic-oils',           'sort_order'=>4],
            ['name'=>'Frozen Pulp',             'slug'=>'frozen-pulp',             'sort_order'=>5],
            ['name'=>'Dehydrated Products',     'slug'=>'dehydrated-products',     'sort_order'=>6],
            ['name'=>'Nuts & Natural Foods',    'slug'=>'nuts-natural-foods',      'sort_order'=>7],
        ];
        foreach ($cats as $c) Category::firstOrCreate(['slug'=>$c['slug']], $c + ['status'=>true]);

        // Collections
        $colls = [
            ['name'=>'Premium Ceylon Cinnamon','slug'=>'premium-ceylon-cinnamon','tag'=>'Export Ready','description'=>'The finest cinnamon from Sri Lanka.','sort_order'=>1],
            ['name'=>'Ceylon Coffee Collection','slug'=>'ceylon-coffee-collection','tag'=>'Best Seller','description'=>'Rich aroma, bold taste. 100% Pure Ceylon.','sort_order'=>2],
            ['name'=>'Ceylon Tea Collection',   'slug'=>'ceylon-tea-collection',   'tag'=>'Featured',    'description'=>'Pure leaves, rich flavour from our tea gardens.','sort_order'=>3],
            ['name'=>'Aromatic Essential Oils', 'slug'=>'aromatic-essential-oils', 'tag'=>'New Range',   'description'=>'Natural oils for wellness and industry.','sort_order'=>4],
        ];
        foreach ($colls as $c) Collection::firstOrCreate(['slug'=>$c['slug']], $c + ['status'=>true]);

        // Products
        $spicesCat  = Category::where('slug','ceylon-spices')->first();
        $coffeeCat  = Category::where('slug','ceylon-coffee')->first();
        $teaCat     = Category::where('slug','ceylon-tea')->first();
        $spiceCat2  = $spicesCat;

        $products = [
            ['category_id'=>$spicesCat?->id, 'name'=>'Ceylon Cinnamon Quills (Alba)', 'slug'=>'ceylon-cinnamon-quills-alba', 'short_description'=>'Premium Alba grade cinnamon quills from Sri Lanka.', 'is_featured'=>true,'is_bestseller'=>true,'is_export_ready'=>true,'sort_order'=>1],
            ['category_id'=>$spicesCat?->id, 'name'=>'Black Pepper Whole 550G/L',    'slug'=>'black-pepper-whole-550gl',    'short_description'=>'High-grade whole black pepper, 550G/L density.', 'is_featured'=>true,'is_bestseller'=>true,'sort_order'=>2],
            ['category_id'=>$teaCat?->id,    'name'=>'Ceylon Green Tea Gun Powder',  'slug'=>'ceylon-green-tea-gun-powder', 'short_description'=>'Premium green tea in gunpowder style.', 'is_new_arrival'=>true,'is_export_ready'=>true,'sort_order'=>3],
            ['category_id'=>$coffeeCat?->id, 'name'=>'Instant Coffee Powder',        'slug'=>'instant-coffee-powder',       'short_description'=>'100% pure Ceylon instant coffee powder.', 'is_featured'=>true,'sort_order'=>4],
            ['category_id'=>$spicesCat?->id, 'name'=>'Clove Whole',                  'slug'=>'clove-whole',                 'short_description'=>'Sun-dried whole cloves from Sri Lanka.', 'is_bestseller'=>true,'is_export_ready'=>true,'sort_order'=>5],
            ['category_id'=>$spicesCat?->id, 'name'=>'Nutmeg Whole',                 'slug'=>'nutmeg-whole',                'short_description'=>'Hand-selected whole nutmeg.', 'is_export_ready'=>true,'sort_order'=>6],
        ];
        foreach ($products as $p) Product::firstOrCreate(['slug'=>$p['slug']], $p + ['status'=>true]);

        // Blog posts
        $posts = [
            ['title'=>'How to Start Import Business from Sri Lanka','slug'=>'how-to-start-import-business-sri-lanka','category'=>'Import Guide','excerpt'=>'A complete guide to importing premium natural products from Sri Lanka.','published_at'=>now()->subDays(5)],
            ['title'=>'Health Benefits of Ceylon Cinnamon You Should Know','slug'=>'health-benefits-ceylon-cinnamon','category'=>'Health & Wellness','excerpt'=>'Discover the remarkable health benefits of authentic Ceylon cinnamon.','published_at'=>now()->subDays(13)],
            ['title'=>'Ceylon Tea vs Other Tea: What Makes It Special?','slug'=>'ceylon-tea-vs-other-tea','category'=>'Tea Culture','excerpt'=>'Why Ceylon tea stands out among all tea varieties in the world.','published_at'=>now()->subDays(18)],
            ['title'=>'Coffee Buying Guide: How to Choose the Best Ceylon Coffee','slug'=>'coffee-buying-guide-ceylon','category'=>'Coffee Guide','excerpt'=>'Everything you need to know before choosing Ceylon coffee for export.','published_at'=>now()->subDays(25)],
        ];
        foreach ($posts as $p) BlogPost::firstOrCreate(['slug'=>$p['slug']], $p + ['status'=>true]);
    }
}
