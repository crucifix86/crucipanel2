<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\View\Components\Hrace009\Front;

use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Widget extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $gms = [];
        foreach (DB::table('auth')->select('userid')->distinct()->get() as $gm) {
            $gms[] = User::find($gm->userid);
        }
        $point = new Point();
        return view('components.hrace009.front.widget', [
            'gms' => $gms,
            'totalUser' => User::count('name'),
            'onlinePlayer' => $point->getOnlinePlayer()
        ]);
    }
}
