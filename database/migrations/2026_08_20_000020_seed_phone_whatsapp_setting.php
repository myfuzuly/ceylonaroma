<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'phone_whatsapp'],
            ['value' => '94718821234', 'updated_at' => now(), 'created_at' => now()]
        );
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'phone_whatsapp')->delete();
    }
};
