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
        Schema::dropIfExists('tracking_shipments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('tracking_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 20)->unique();
            $table->string('current_status', 32)->default('assigned');
            $table->string('last_event_type', 32)->nullable();
            $table->dateTime('last_event_at')->nullable();
            $table->decimal('last_latitude', 10, 7)->nullable();
            $table->decimal('last_longitude', 10, 7)->nullable();
            $table->text('last_notes')->nullable();
            $table->timestamps();

            $table->index(['current_status', 'last_event_at']);
        });
    }
};
