<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();

            $table->string('slug')->nullable();

            $table->string('name')->nullable();
            $table->string('title')->nullable();

            $table->text('short_description')->nullable();
            $table->text('description')->nullable();

            $table->timestamp("date_in")->nullable();
            $table->integer('views')->default(0);
            $table->boolean('published')->default(false);
            $table->boolean('paid_content')->default(false);

            $table->foreignIdFor(User::class)->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
