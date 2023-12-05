<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class AddNotificationDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_deliveries', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notification_id');
            $table->string('type');
            $table->string('transport');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('notification_id')
                ->references('id')->on('notifications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notification_deliveries');
    }
}
