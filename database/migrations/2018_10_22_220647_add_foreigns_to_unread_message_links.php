<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToUnreadMessageLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unread_message_links', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('message_id')->references('id')->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unread_message_links', function (Blueprint $table) {
            $table->dropForeign('unread_message_links_user_id_foreign');
            $table->dropForeign('unread_message_links_group_id_foreign');
            $table->dropForeign('unread_message_links_message_id_foreign');
        });
    }
}
