<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BakeryModel extends Model
{
    protected $table = 'table_bakery_menu';

    protected $fillable = [
        'name',
        'price',
        'brand',
        'image',
        'flavor',
        'description',
    ];
}
