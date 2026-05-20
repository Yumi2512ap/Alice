<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
Schema::create('categories', function (Blueprint $table) {

$table->id('category_id');

$table->string('category_name', 100);

$table->integer('best_before_date_days');

$table->timestamps();

$table->softDeletes();
});
}

public function down(): void
{
Schema::dropIfExists('categories');
}
};
