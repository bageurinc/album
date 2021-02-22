<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KomentarAlbum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_komen_album', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable();
            $table->foreignId('komen_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->longText('text')->nullable();
            $table->string('nama_album')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_komen_album');
    }
}
