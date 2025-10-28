<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function promoteToCompany(User $user)
    {
        $user->role = 'company';
        $user->save();
        return back()->with('success','Rol actualizado a Company.');
    }

    public function promoteToAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();
        return back()->with('success','Rol actualizado a Admin.');
    }

    public function demoteToStudent(User $user)
    {
        $user->role = 'student';
        $user->save();
        return back()->with('success','Rol actualizado a Student.');
    }
}
