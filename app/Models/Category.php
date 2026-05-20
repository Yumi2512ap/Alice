<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'best_before_date_days',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'category_id');
    }
}
