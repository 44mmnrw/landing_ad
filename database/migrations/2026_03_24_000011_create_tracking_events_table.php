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
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_uid', 100)->unique();
            $table->string('tracking_number', 20);
            $table->string('event_type', 32);
            $table->string('status', 32);
            $table->dateTime('occurred_at');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('notes')->nullable();
            $table->string('source_system', 64);
            $table->dateTime('received_at');
            $table->timestamps();

            $table->index(['tracking_number', 'occurred_at']);
            $table->index(['tracking_number', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_events');
    }
};
