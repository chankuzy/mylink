<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->text('content')->nullable();
            $table->text('hashtags')->nullable();
            $table->string('media_type')->nullable();
            // Rename 'image' column to 'media' if it exists
            if (Schema::hasColumn('posts', 'image')) {
                $table->renameColumn('image', 'media');
            } else {
                $table->string('media')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['location', 'content', 'hashtags', 'media_type']);
            if (Schema::hasColumn('posts', 'media')) {
                $table->renameColumn('media', 'image');
            }
        });
    }
};