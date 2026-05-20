<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
use SoftDeletes;

protected $primaryKey = 'stock_id';

protected $fillable = [
'arrival_date',
'receiving_count',
'item_id',
'stat_id',
'expiration_date',
];

protected $casts = [
'arrival_date' => 'date',
'expiration_date' => 'date',
];

public function item()
{
return $this->belongsTo(Item::class, 'item_id', 'item_id');
}

public function status()
{
return $this->belongsTo(Status::class, 'stat_id', 'stat_id');
}

public function issuings()
{
return $this->hasMany(Issuing::class, 'stock_id', 'stock_id');
}
}
