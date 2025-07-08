<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Livewire\Hrace009\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUser extends Component
{
    use WithPagination;

    public $term = '';

    public function render()
    {
        if (empty($this->term)) {
            // Return empty paginator when no search term
            $users = User::where('id', '<', 0)->paginate(15);
        } else {
            $users = User::where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->term . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->term . '%')
                    ->orWhere('truename', 'LIKE', '%' . $this->term . '%');
            })->paginate(15);
        }
        
        return view('livewire.hrace009.admin.search-user', [
            'users' => $users
        ]);
    }
}
