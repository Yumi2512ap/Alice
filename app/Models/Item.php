<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
protected $primaryKey = 'item_id';

protected $fillable = [
'item_name',
'category_id',
];

public function category()
{
return $this->belongsTo(Category::class, 'category_id', 'category_id');
}

public function stocks()
{
return $this->hasMany(Stock::class, 'item_id', 'item_id');
}
}
