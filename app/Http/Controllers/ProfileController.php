<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {   
        $get = Profile::query()
            ->where('isVerified','0')
            ->where('isRejected','0')
            ->orderBy('id','DESC')
            ->paginate(10);
        
        return view('admin.membership.index', [

            'memberships' => $get

        ]);
    }

    public function create()
    {   
        $user = User::query()
            ->with('profile')
            ->where('id',auth()->user()->id)
            ->orderBy('id','DESC')
            ->first();
        return view('users.profile.create', [

            'user' => $user

        ]);

    }

    public function store(Request $request)
    {
        if(!auth()->user()) {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        $validate = Validator::make($request->all(),[

            'membership_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if($validate->fails()) {

            return redirect()->back()->withErrors($validate);

        }
        $image = $request->membership_img;
        $membership_img = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/card'),$membership_img);

        Profile::create([

            'membership_img' => $membership_img,
            'profile_id' => auth()->user()->id

        ]);

        return redirect()->back()->with('message','Successfully submitted a card. Please wait 1-2days for verification.');
    }
    public function approveProfile(Profile $profile) 
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        Profile::findOrfail($profile->id)->update([

            'isVerified' => $profile->isVerified =! $profile->isVerified,
            'hasMembership' => $profile->hasMembership =! $profile->hasMembership,

        ]);

        User::findOrfail($profile->profile_id)->update([

            'isVerified' => $profile->getUser->isVerified =! $profile->getUser->isVerified,

        ]);

        return redirect()->back()->with('message','Successfully approve profile '.$profile->getUser->name);
    }
    
    public function disapproveProfile(Profile $profile) 
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        Profile::findOrfail($profile->id)->update([

            'isRejected' => $profile->isRejected =! $profile->isRejected,

        ]);
        return redirect()->back()->with('message','Successfully rejected profile '.$profile->getUser->name);
    }

    public function show(Profile $profile)
    {
        //
    }

    public function edit(User $user)
    {
       
    }

    public function update(Request $request, Profile $profile)
    {
    }

    public function destroy(Profile $profile)
    {
        //
    }
}
