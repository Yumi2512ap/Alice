<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
Schema::create('types', function (Blueprint $table) {
$table->id('category_id');
$table->string('category_name', 100);
$table->integer('best_before_days');
$table->date('created_at')->nullable();
$table->date('updated_at')->nullable();
$table->date('deleted_at')->nullable();
});
}
};
