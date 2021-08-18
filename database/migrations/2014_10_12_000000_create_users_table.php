<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('permissionsJson');
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('roles')->insert(
            array(
                "name" => "admin",
                "permissionsJson" => json_encode([
                    "get_item" => true,
                    "create_item" => true,
                    "edit_item" => true,
                    "delete_item" => true,
                    "get_category" => true,
                    "create_category" => true,
                    "edit_category" => true,
                    "delete_category" => true,
                    "get_order" => true,
                    "create_order" => true,
                    "edit_order" => true,
                    "delete_order" => true,
                    "get_user" => true,
                    "create_user" => true,
                    "edit_user" => true,
                    "delete_user" => true,
                    "get_role" => true,
                    "create_role" => true,
                    "edit_role" => true,
                    "delete_role" => true
                ])
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'admin',
                'role_id' => 1,
                'password' => '00000000',
                'email' => 'hesham61@gmail.com'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
}
