<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'nav_title',
        'content',
        'active',
        'order',
        'show_in_nav',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_in_nav' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && !$page->isDirty('slug')) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInNav($query)
    {
        return $query->where('show_in_nav', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
