<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentMethods extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name', 'description'];

    public $fillable = ['name',
        'description',
        'image',
        'status',
    ];
}
