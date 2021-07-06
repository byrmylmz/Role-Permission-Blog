<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           // $table->unsignedBigInteger('role_id')->default(1); // we used default 1 to specified the role as default // also this area added the user model as fillable.
          //  $table->foreign('role_id')->references('id')->on('roles');
        });
        // we need another data transformation in the same migration because of is_admin field
        // we should assign is_admin field to add role id
        
       // \App\Models\User::where('is_admin',1)->update(['role_id'=>2]); // if is admin equel to 1 update the role id as 2 when creating new field of role id. Actually here we entered default value for the is_admin field.
        
        // after above process. We are gonna remove the the is_admin column in database.
        // Before remove the column take backup of database. 
        Schema::table('users', function (Blueprint $table) {
          //  $table->dropColumn('is_admin');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
