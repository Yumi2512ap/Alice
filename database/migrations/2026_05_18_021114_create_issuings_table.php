<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
Schema::create('issue_logs', function (Blueprint $table) {
$table->id('issuing_id');
$table->unsignedBigInteger('stock_id');
$table->date('issuing_date');
$table->integer('issuing_count');
$table->string('evaluation', 100);
$table->string('repeat', 100);
$table->date('created_at')->nullable();
$table->date('updated_at')->nullable();
$table->date('deleted_at')->nullable();

$table->foreign('stock_id')->references('stock_id')->on('stocks');
});
}
};
