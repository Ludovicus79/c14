<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    public function get(Request $request){
        $users=User::paginate(15);
        return view('admin.users',['users'=>$users]);
    }

    public function show($id) {
	   $user = User::find($id);
	   return view('admin.usersShow',['user'=>$user]);
}

    public function destroy($id)
	{
		$usuario = User::find($id);
		$usuario->delete();
		$users=User::simplePaginate(15);
		return redirect('admin/users')
				->with('users', $users)
				->with('eliminado', "Usuario eliminado correctamente");

	}

}
