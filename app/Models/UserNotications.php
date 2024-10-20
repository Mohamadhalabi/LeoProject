<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserNotications extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'user_notifications'; // Specify table name if it differs from the model name
    
    protected $fillable = [
        'title',
        'status',
    ];
    public $translatable = ['title'];

}
