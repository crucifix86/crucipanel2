<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pwp_factions';
    
    /**
     * The primary key type
     *
     * @var string
     */
    protected $keyType = 'int';
    
    /**
     * Indicates if the primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var string[]
     */
    protected $fillable = ['id', 'name', 'level', 'master', 'master_name', 'members', 'time_used', 'pk_count', 'announce', 'sys_info', 'last_op_time', 'territories', 'contribution'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $query
     * @param $sub
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubType($query, $sub)
    {
        $column = [
            'level' => 'level',
            'members' => 'members',
            'territories' => 'territories',
            'pvp' => 'pk_count',
        ];

        return $query
            ->whereNotIn('id', explode(',', config('pw-config.ignoreFaction')))
            ->orderBy($column[$sub] ?? 'level', 'desc');
    }
}
