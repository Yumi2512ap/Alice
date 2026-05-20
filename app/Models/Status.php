<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
protected $primaryKey = 'stat_id';

protected $fillable = [
'stat_name',
];

public function stocks()
{
return $this->hasMany(Stock::class, 'stat_id', 'stat_id');
}
}
