<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'courses', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->text( 'description' );
            $table->unsignedTinyInteger( 'rating' )->nullable();
            $table->unsignedInteger( 'view' )->default( 0 );
            $table->enum( 'level', [ 'beginner', 'immediate', 'high' ] );
            $table->unsignedInteger( 'hours' )->nullable();
            $table->boolean( 'active' )->default( TRUE );
            $table->foreignId( 'category_id' )->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'courses' );
    }

}
