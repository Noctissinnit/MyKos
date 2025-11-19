<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('rental_request_id')->nullable()->constrained('rental_requests')->onDelete('cascade');
            $table->string('bukti')->nullable();
            $table->boolean('verified')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rental_request_id');
            $table->dropColumn('bukti');
            $table->dropColumn('verified');
        });
    }
};
