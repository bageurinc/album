<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Album extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_album', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_seo');
            $table->string('group')->nullable();
            $table->string('group_seo')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        }); 

        Schema::create('bgr_albumdetail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id');
            $table->string('gambar')->nullable();
            $table->string('status')->default('aktif');
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
        Schema::dropIfExists('bgr_album');
        Schema::dropIfExists('bgr_albumdetail');
    }
}
