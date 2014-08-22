<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_links', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('provider', 32);
            $table->string('social_id', 64);
            $table->timestamps();
        });

        Schema::table('social_links', function($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('social_links', function($table) {
            $table->dropForeign('social_links_user_id_foreign');
        });

        Schema::drop('social_links');
	}

}
