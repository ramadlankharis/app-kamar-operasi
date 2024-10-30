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
        Schema::create('display_oks', function (Blueprint $table) {
            $table->id();
            $table->integer('squence_status_operasi');
            $table->string('nama_ruangan');
            $table->boolean('is_active')->default(true);
            $table->text('sender')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display_oks');
    }
};
