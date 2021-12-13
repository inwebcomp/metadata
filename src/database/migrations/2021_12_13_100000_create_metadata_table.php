<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use InWeb\Media\Images\Image;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->integer('metadatable_id');
            $table->string('metadatable_type');
            $table->timestamps();

            $table->unique(['metadatable_id', 'metadatable_type']);
        });

        Schema::create('metadata_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('metadata_id');
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();

            $table->unique(['metadata_id','locale']);
            $table->foreign('metadata_id')->references('id')->on('metadata')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata');
    }
}
