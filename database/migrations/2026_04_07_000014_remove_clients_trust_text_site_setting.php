<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        DB::table('site_settings')
            ->where('key', 'clients_trust_text')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'clients_trust_text'],
            [
                'value' => 'Более 100 довольных клиентов по всей России',
                'is_public' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
};
