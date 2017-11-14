<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('commentid');
            $table->integer('item_id');
            $table->mediumText('description');
            $table->integer('userid');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index('item_id');
            $table->index('userid');
            $table->timestamps();
            $table->engine = 'MyISAM';
        });
        DB::statement('ALTER TABLE comments ADD FULLTEXT INDEX comments_fts (description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('comments');
    }
}
