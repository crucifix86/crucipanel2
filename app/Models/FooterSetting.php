<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'content',
        'copyright',
        'alignment',
        'footer_image',
        'footer_image_link',
        'footer_image_alt'
    ];
}
