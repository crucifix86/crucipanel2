<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactionIconSetting extends Model
{
    protected $fillable = [
        'enabled',
        'icon_size',
        'max_file_size',
        'cost_virtual',
        'cost_gold',
        'require_approval',
        'auto_deploy',
        'allowed_formats',
    ];
    
    protected $casts = [
        'enabled' => 'boolean',
        'require_approval' => 'boolean',
        'auto_deploy' => 'boolean',
        'allowed_formats' => 'array',
    ];
    
    /**
     * Get the current settings instance
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'enabled' => true,
            'icon_size' => 24,
            'max_file_size' => 204800,
            'cost_virtual' => 0,
            'cost_gold' => 100000,
            'require_approval' => true,
            'auto_deploy' => false,
            'allowed_formats' => ['png', 'jpg', 'jpeg', 'gif'],
        ]);
    }
    
    /**
     * Get the max file size in MB
     */
    public function getMaxFileSizeInMb()
    {
        return round($this->max_file_size / 1024 / 1024, 2);
    }
    
    /**
     * Get the cost display string
     */
    public function getCostDisplay()
    {
        $costs = [];
        
        if ($this->cost_virtual > 0) {
            $costs[] = number_format($this->cost_virtual) . ' ' . config('pw-config.currency_name', 'Virtual Currency');
        }
        
        if ($this->cost_gold > 0) {
            $costs[] = number_format($this->cost_gold / 10000, 2) . ' Gold';
        }
        
        return empty($costs) ? 'Free' : implode(' + ', $costs);
    }
}