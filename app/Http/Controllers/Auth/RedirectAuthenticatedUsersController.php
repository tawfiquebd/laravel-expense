<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home() {

        foreach (auth()->user()->roles as $role) {
            if ($role['id'] == 1) {
                return redirect('/admin');
            }
            else if($role['id'] == 2){
                return redirect('/');
            }
        }

    }
}
