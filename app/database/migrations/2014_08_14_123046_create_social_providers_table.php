<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /*
		Schema::create('social_providers', function($table){
            $table->increments('id');
            $table->string('uid', 32)->unique();
            $table->string('link', 256)->nullable()->default(null);
            $table->string('logo', 256)->nullable()->default(null);
        });
        */
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        if (Schema::hasTable('social_providers')) {
            Schema::drop('social_providers');
        }
	}

}
