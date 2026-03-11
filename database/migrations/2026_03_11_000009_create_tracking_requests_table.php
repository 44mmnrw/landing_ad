<?php

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
        Schema::create('tracking_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('search_code', 50)->nullable();
            $table->boolean('is_found')->default(false);
            $table->string('source_page')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('search_code');
            $table->index('is_found');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_requests');
    }
};
