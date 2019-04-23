<?php

use \Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Schema;

/**
 * Class AclGroupPermissions
 */
class GroupPermissions extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('group_permissions')) {
            Schema::create('group_permissions', function ($table) {
                $table->increments('id');
                $table->integer('group_id');
                $table->integer('permission_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_permissions');
    }
}
