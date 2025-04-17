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
        Schema::create('olts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->enum('type', ['ZTE', 'HUAWEI', 'ALCATEL', 'OTHER']);
            $table->string('snmp_community')->default('public');
            $table->integer('snmp_port')->default(161);
            $table->string('ssh_username')->nullable();
            $table->string('ssh_password')->nullable();
            $table->integer('ssh_port')->nullable()->default(22);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olts');
    }
};
