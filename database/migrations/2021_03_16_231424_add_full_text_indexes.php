<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullTextIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * Only uncomment the fulltext line if you are using mysql
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->index(['from', 'to', 'subject']);
//            $table->fulltext(['subject', 'to', 'from']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['from', 'to', 'subject']);
//            $table->dropFulltext(['subject', 'to', 'from']);
        });
    }
}
