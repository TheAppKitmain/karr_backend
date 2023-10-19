<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        $adminData = Role::where('name', 'admin')->first();
        if ($adminData) {
            $data = $adminData->users;
            return view('superAdmin.adminList', ['users' => $data], compact('data'));
        }
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $validatedData['name'] . '.' . $extension;
                $image->move(public_path('image'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e . 'Failed to create user. Please try again.');
        }
    }

    public function show($id)
    {

        $user = Auth::user();
        $role = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.show', compact('user', 'role', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming data
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|same:confirm-password',
                'roles' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            // Find the user to update
            $user = User::find($id);

            // Update name and email
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

            // Update password if provided
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            // Update image if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = $validatedData['name'] . '.' . $extension;
                $image->move(public_path('image'), $imageName);

                // Delete the old image if it exists
                if (!empty($user->image)) {
                    $oldImagePath = public_path('image') . '/' . $user->image;
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }

                $user->image = $imageName;
            }

            // Save the user's updated information
            $user->save();

            // Remove existing roles and assign the new roles
            $user->syncRoles($request->input('roles'));

            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e . 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function showProfile()
    {
        $user = User::all();

        return view('profile', compact('user'));
    }

    public function setting($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('profile.profile', compact('user', 'roles', 'userRole'));
    }
}
