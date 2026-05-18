<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
Schema::create('stocks', function (Blueprint $table) {
$table->id('stock_id');
$table->date('arrival_date');
$table->integer('receiving_count');
$table->unsignedBigInteger('item_id');
$table->unsignedBigInteger('stat_id');
$table->date('expiration_date');
$table->date('created_at')->nullable();
$table->date('updated_at')->nullable();
$table->date('deleted_at')->nullable();

$table->foreign('item_id')->references('item_id')->on('items');
$table->foreign('stat_id')->references('stat_id')->on('statuses');
});
}
};
