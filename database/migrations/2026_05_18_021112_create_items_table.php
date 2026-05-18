<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
Schema::create('items', function (Blueprint $table) {
$table->id('item_id');
$table->string('item_name', 100);
$table->unsignedBigInteger('category_id');
$table->date('created_at')->nullable();
$table->date('updated_at')->nullable();
$table->date('deleted_at')->nullable();

$table->foreign('category_id')->references('category_id')->on('types');
});
}
};
