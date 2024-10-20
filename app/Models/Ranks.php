<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ranks extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'description'];

    public $fillable = ['title',
        'description',
        'image',
        'status',
        'coupon_value'
    ];
}
