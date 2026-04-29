<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentRole = auth()->user()->role;

        // allowed roles depende kung sino ang gumawa
        $allowedRoles = $currentRole === 'superadmin'
            ? ['superadmin', 'admin', 'user']
            : ['user'];

        $this->validate($request, [
            'name' => 'string|required|max:30',
            'email' => 'string|required|unique:users',
            'password' => 'string|required',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);


        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);
            $data['photo'] = 'uploads/users/' . $filename;
        }

        $status = User::create($data);

        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $currentUser = auth()->user();

    // Kung admin lang at gusto nyang i-edit ay admin/superadmin -> bawal
    if ($currentUser->role === 'admin' && in_array($user->role, ['admin', 'superadmin'])) {
        return redirect()->route('users.index')
            ->with('error', 'You are not allowed to update this account.');
    }

    // Allowed roles depende kung sino ang nag-update
    $allowedRoles = $currentUser->role === 'superadmin'
        ? ['superadmin', 'admin', 'user']
        : ['user'];

    $this->validate($request, [
        'name'   => 'string|required|max:30',
        'email'  => 'string|required|unique:users,email,' . $user->id,
        'role'   => 'required|in:' . implode(',', $allowedRoles),
        'status' => 'required|in:active,inactive',
        'photo'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'role', 'status']);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/users'), $filename);
        $data['photo'] = 'uploads/users/' . $filename;
    }

    $status = $user->fill($data)->save();

    if ($status) {
        request()->session()->flash('success', 'Successfully updated');
    } else {
        request()->session()->flash('error', 'Error occurred while updating');
    }

    return redirect()->route('users.index');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete photo if exists
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $status = $user->delete();

        if ($status) {
            request()->session()->flash('success', 'User successfully deleted');
        } else {
            request()->session()->flash('error', 'There was an error while deleting the user');
        }

        return redirect()->route('users.index');
    }
}
