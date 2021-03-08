<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_status', function (Blueprint $table) {
            $table->string('status_message')->nullable();
            $table->unsignedBigInteger('email_id')->index();
            $table->unsignedSmallInteger('status_id')->index();
            $table->foreign('email_id')->references('id')->on('emails');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->primary(['status_id', 'email_id']);
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
        Schema::dropIfExists('email_status');
    }
}
