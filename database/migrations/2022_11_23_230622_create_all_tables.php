<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabela de usuários
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('avatar')->default('default.png');
            $table->string('email')->unique();
            $table->string('password');
        });
        
        // Tabela de barbeiros favoritos dos usuários
        Schema::create('userfavorites', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_barber');
        });

        // Tabela de agendamentos
        Schema::create('userappointments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_barber');
            $table->datetime('ap_datetime');
        });

        // Tabela de barbeiros
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('avatar')->default('default.png');
            $table->float('stars')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });

        // Tabela de fotos do barbeiro
        Schema::create('barberphotos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barber');
            $table->string('url');
        });

        // Tabela de reviews do barbeiro
        Schema::create('barberreviews', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barber');
            $table->float('rate');
        });

        // Tabela de serviços do barbeiro
        Schema::create('barberservices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barber');
            $table->string('name');
            $table->float('price');
        });

        // Tabela de depoimentos sobre o barbeiro
        Schema::create('barbertestimonials', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barber');
            $table->string('name');
            $table->float('rate');
            $table->string('body');
        });

        // Tabela de disponibilidade do barbeiro
        Schema::create('barberavailability', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barber');
            $table->integer('weekday');
            $table->text('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('userfavorites');
        Schema::dropIfExists('userappointments');
        Schema::dropIfExists('barbers');
        Schema::dropIfExists('barberphotos');
        Schema::dropIfExists('barberreviews');
        Schema::dropIfExists('barberservices');
        Schema::dropIfExists('barbertestimonials');
        Schema::dropIfExists('barberavailability');
    }
};
