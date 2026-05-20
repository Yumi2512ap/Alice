<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issuing extends Model
{
protected $primaryKey = 'issuing_id';

protected $fillable = [
'stock_id',
'issuing_date',
'issuing_count',
'evaluation',
'repeat',
];

protected $casts = [
'issuing_date' => 'date',
];

public function stock()
{
return $this->belongsTo(Stock::class, 'stock_id', 'stock_id');
}
}
