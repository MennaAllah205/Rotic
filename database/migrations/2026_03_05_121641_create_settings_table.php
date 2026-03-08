<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // name ar / en
            $table->json('name')->nullable();
            // logo
            $table->string('logo')->nullable();


            // social links
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();

            

            // contact info
            $table->string('email')->nullable();
            $table->string('first_phone_number')->nullable();
            $table->string('second_phone_number')->nullable();

            $table->json('meta')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
