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
        if (Schema::hasTable('tracking_requests') && Schema::hasColumn('tracking_requests', 'shipment_id')) {
            Schema::table('tracking_requests', function (Blueprint $table) {
                $table->dropConstrainedForeignId('shipment_id');
            });
        }

        Schema::dropIfExists('shipment_statuses');
        Schema::dropIfExists('shipments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('shipments')) {
            Schema::create('shipments', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('route');
                $table->string('cargo_type');
                $table->decimal('weight_kg', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('shipment_statuses')) {
            Schema::create('shipment_statuses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->string('place')->nullable();
                $table->dateTime('happened_at')->nullable();
                $table->boolean('is_done')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();

                $table->index(['shipment_id', 'sort_order']);
            });
        }

        if (Schema::hasTable('tracking_requests') && ! Schema::hasColumn('tracking_requests', 'shipment_id')) {
            Schema::table('tracking_requests', function (Blueprint $table) {
                $table->foreignId('shipment_id')->nullable()->constrained()->nullOnDelete()->after('id');
            });
        }
    }
};
