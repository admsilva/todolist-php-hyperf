<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->string('title');
            $table->text('description');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('priority');
            $table->uuid('user_uuid');
            $table->datetimes();
            $table->softDeletes();
            $table->unique(['title', 'start_at', 'user_uuid', 'deleted_at']);
            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
