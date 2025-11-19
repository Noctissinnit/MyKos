<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // NOTE: altering columns requires the doctrine/dbal package to be installed in some environments.
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('penghuni_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('penghuni_id')->nullable(false)->change();
        });
    }
};
