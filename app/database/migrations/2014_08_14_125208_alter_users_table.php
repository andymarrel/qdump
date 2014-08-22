<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
            $table->string('social_provider', 32)->nullable()->default(null);
            $table->string('social_uid', 64)->nullable()->default(null);
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table){
            $table->dropColumn('social_provider');
            $table->dropColumn('social_uid');
            $table->dropColumn('deleted_at');
        });
	}

}
