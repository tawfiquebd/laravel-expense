<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        $adminsCount = Role::where('id', 1)->first()->users()->count();
        $usersCount = Role::where('id', 2)->first()->users()->count();

        return view("backend.admin.adminDashboard", compact('adminsCount', 'usersCount'));
    }

    public function users() {
        $basicUsers = Role::all()
            ->where('id', 2)
            ->first()
            ->users()
            ->get();

        return view('backend.admin.users', compact('basicUsers'));
    }

    public function userStatus($userId) {

        $getStatus = User::where('id', $userId)->first();

        if($getStatus->status == 1) {
            $getStatus->status = 0;
            $getStatus->save();

            return redirect()->back();
        }
        else {
            $getStatus->status = 1;
            $getStatus->save();

            return redirect()->back();
        }
//        dd($updateStatus->status);
    }
}
