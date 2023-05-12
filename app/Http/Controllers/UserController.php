<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EditHistory;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserController extends Controller
{


    public function index()
    {
        if (auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning', 'Unauthorized action.');
        }
        $users = User::query()
        
        ->where('isDeleted','0')
        ->with('profile')
        ->get();
        
        $userCount = count($users);

        return view('admin.user-management.index', [

            'users' => $users,
            'userCount' => $userCount

        ]);
    }

    public function create() {


        return view('admin.user-management.create');
    }

    public function store(Request $request) {

        $validate = Validator::make($request->all(), [

            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:users',

        ]);

        if ($validate->fails()) {

            return redirect()->back()->withErrors($validate);
        }
        $image = $request->avatar;
        $avatar = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/avatar'), $avatar);
        $password = Hash::make($request->password);
        User::create([

            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'role' => $request->role,
            'expertise' => $request->expertise,
            'password' => $request->password,
            'avatar' => $avatar,
            'isActive' => 1,
        ]);

        return redirect()->back()->with('message', 'Successfully added a user.');
    }

    public function show(User $user)
    {
        if (auth()->user()->role != 'Admin') {
            return redirect()->back()->with('warning', 'Unauthorized action.');
        }

        $employee = Employee::query()
            ->with('branch')
            ->where('barber_id', $user->id)
            ->first();

        return view('admin.user-management.show', [
            'user' => $user,
            'branch_name' => $employee->branch->branch_name ?? 'N/A',
        ]);
    }

    public function destroy(User $user) {

        if (auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning', 'Unauthorized action.');
        }

        User::findOrfail($user->id)->update([

            'isDeleted' => $user->isDeleted =! $user->isDeleted,
            
        ]);

        return redirect()->back()->with('message', 'successfully deleted user ' . $user->name);
    }
    public function edit(User $user) {

        return view('users.edit', [

            'user' => $user

        ]);
    }
    // public function update(Request $request, User $user)
    // {
    //     if (!auth()->user()) {

    //         return redirect()->back()->with('warning', 'Unauthorized action.');
    //     }

    //     $validate = Validator::make($request->all(), [

    //         'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',

    //     ]);

    //     if ($validate->fails()) {

    //         return redirect()->back()->withErrors($validate);
    //     }
    //     $image = $request->avatar;
    //     $avatar = rand() . '.' . $image->getClientOriginalExtension();
    //     $image->move(public_path('images/avatar'), $avatar);

    //     User::findOrfail($user->id)->update([

    //         'name' => $request->name,
    //         'address' => $request->address,
    //         'contact_no' => $request->contact_no,
    //         'avatar' => $avatar,

    //     ]);

    //     return redirect()->back()->with('message', 'successfully updated info');
    // }
    // 
    
    public function update(Request $request, User $user)
    {
        $appointment_name = auth()->user()->name;
        // dd($appointment_name);
    // validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    // update the user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->contact_no = $request->contact_no;

    // check if the avatar is being updated
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

        // generate a unique filename
            $image = $request->avatar;
            $filename = rand() . '.' . $image->getClientOriginalExtension();

        // store the file in storage/app/public/avatars
            $avatar->move(public_path('images/avatar'), $filename);

        // update the user's avatar
            $user->avatar = $filename;
        }

    // check if any fields have changed
        $fields_changed = false;
        $changed_fields = [];

        if ($user->isDirty('name')) {
            $fields_changed = true;
            $changed_fields[] = 'name';
        }

        if ($user->isDirty('email')) {
            $fields_changed = true;
            $changed_fields[] = 'email';
        }

        if ($user->isDirty('address')) {
            $fields_changed = true;
            $changed_fields[] = 'address';
        }

        if ($user->isDirty('contact_no')) {
            $fields_changed = true;
            $changed_fields[] = 'contact_no';
        }

        if ($user->isDirty('avatar')) {
            $fields_changed = true;
            $changed_fields[] = 'avatar';
        }

        if ($fields_changed) {
            foreach ($changed_fields as $field) {
                $oldValue = $user->getOriginal($field);
                $newValue = $user->{$field};

                EditHistory::create([
                    'user_id' => $user->id,
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                ]);
            }

        // save the updated user
            $user->save();



        // Create a separate EditHistory record for the customer name
            $editorHistory = new EditHistory();
            $editorHistory->user_id = $user->id;
            $editorHistory->field = 'Updated by';
            $editorHistory->old_value = null;
            $editorHistory->new_value = $appointment_name;
            $editorHistory->save();

        // redirect back to the user's profile page with a success message
            return redirect()->route('users.edit', $user)->with('message', 'User updated successfully.');
        } else {
        // redirect back to the user's profile page with a message indicating no changes were made
            return redirect()->route('users.edit', $user)->with('warning', 'Nothing is updated.');
        }
    }

    public function changePassword(Request $request)
    {
        return view('users.profile.change-pass');
    }

    public function storeChangepass(Request $request)
    {
        $request->validate([

            'old_pass' => 'required',
            'new_pass' => 'required|min:8|string',
            'confirm_pass' => 'required|min:8|string',

        ]);

        if (Hash::check($request->old_pass, auth()->user()->password)) {

            if($request->new_pass != $request->confirm_pass)
            {
                return back()->with('warning','Confirm pass not match!');
            }
            User::findOrfail(auth()->user()->id)->update([

                'password' => Hash::make($request->new_pass)

            ]);

            return redirect()->back()->with('message', 'successfully changed the password.');
        }
        else {
            return back()->with('warning','Old pass not match');
        }

    }

    public function hasMembership($user_id) {

        $user = User::find($user_id);
        $user->load('profile');
        
        return $user->profile->hasMembership ?? 0;
    }

    public function editBarber(User $user)
    {

        return view('admin.user-management.edit', [

            'user' => $user

        ]);
    }


    public function barberUpdate(Request $request, User $user)
    {

        $appointment_name = auth()->user()->name;

    // validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'expertise' => 'required|string|max:255',
            'isActive' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    // update the user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->contact_no = $request->contact_no;
        $user->expertise = $request->expertise;
        $user->isActive = $request->isActive;

    // check if the avatar is being updated
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

        // generate a unique filename
            $image = $request->avatar;
            $filename = rand() . '.' . $image->getClientOriginalExtension();

        // store the file in storage/app/public/avatars
            $avatar->move(public_path('images/avatar'), $filename);

        // update the user's avatar
            $user->avatar = $filename;
        }

    // check if any fields have changed
        $fields_changed = false;
        $changed_fields = [];

        if ($user->isDirty('name')) {
            $fields_changed = true;
            $changed_fields[] = 'name';
        }

        if ($user->isDirty('email')) {
            $fields_changed = true;
            $changed_fields[] = 'email';
        }

        if ($user->isDirty('address')) {
            $fields_changed = true;
            $changed_fields[] = 'address';
        }

        if ($user->isDirty('contact_no')) {
            $fields_changed = true;
            $changed_fields[] = 'contact_no';
        }

        if ($user->isDirty('expertise')) {
            $fields_changed = true;
            $changed_fields[] = 'expertise';
        }

        if ($user->isDirty('isActive')) {
            $fields_changed = true;
            $changed_fields[] = 'isActive';
        }

        if ($user->isDirty('avatar')) {
            $fields_changed = true;
            $changed_fields[] = 'avatar';
        }

        if ($fields_changed) {
            foreach ($changed_fields as $field) {
                $oldValue = $user->getOriginal($field);
                $newValue = $user->{$field};

                EditHistory::create([
                    'user_id' => $user->id,
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'user' => auth()->user()->name,
                ]);
            }

        // save the updated user
            $user->save();

        // Create a separate EditHistory record for the customer name
            $editorHistory = new EditHistory();
            $editorHistory->user_id = $user->id;
            $editorHistory->field = 'Updated by';
            $editorHistory->old_value = null;
            $editorHistory->new_value = $appointment_name;
            $editorHistory->save();

        // redirect back to the user's profile page with a success message
            return redirect()->route('users.show', $user)->with('message', 'User updated successfully.');
        } else {
        // redirect back to the user's profile page with a message indicating no changes were made
            return redirect()->route('users.show', $user)->with('message', 'Nothing is updated.');
        }
    }


}
