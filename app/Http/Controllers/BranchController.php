<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning', 'Unauthorized action.');
        }

        $getBranch = Branch::query()    
            ->orderBy('id','DESC')
            ->paginate(10);
        return view('admin.branches.index', [

            'branches' => $getBranch

        ]);
    }


    public function create(Branch $branch)
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        return view('admin.branches.create');
    }

  
    public function store(Request $request)
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        $validate = Validator::make($request->all(),[

            'branch_name' => 'required|string|max:100',
            'branch_location' => 'required|string|max:250',
            'branch_details' => 'required|string|max:100',
            'google_href' => 'required|string',
            'branch_open' => 'required',
            'branch_close' => 'required',
            'branch_open_from' => 'required',
            'branch_open_upto' => 'required',
            'branch_contact' => 'required',
            'branch_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if($validate->fails()) {

            return redirect()->back()->withErrors($validate);

        }

       

        $image = $request->branch_img;
        $branch_img = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/branch_images'),$branch_img);

        $latestNumber = Branch::orderBy('id','DESC')->first();

        if(empty($latestNumber)) {

            $getnewID = 1;
        } 
        else {

            $getnewID = $latestNumber->id + 1;
        }
        
        Branch::create([

            'branch_name' => $request->branch_name,
            'branch_location' => $request->branch_location,
            'branch_details' => $request->branch_details,
            'google_link'=> $request->google_href,
            'branch_open' => $request->branch_open,
            'branch_close' => $request->branch_close,
            'branch_contact' => $request->branch_contact,
            'branch_img' => $branch_img,
            'day_open' => $request->branch_open_from.'-'.$request->branch_open_upto,
            'user_id' => auth()->user()->id,
            'branch_number' => random_int(1000,10000).'-'.$getnewID

        ]);

        return redirect()->back()->with('message','Successfully posted a branch.');

    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit',['branch' => $branch]);
    }


    public function update(Request $request, Branch $branch)
    {
        Branch::findOrfail($branch->id)->update([

            'branch_name' => $request->branch_name,
            'branch_location' => $request->branch_location,
            'branch_details' => $request->branch_details,
            'google_link' => $request->google_link,
            'branch_open' => $request->branch_open,
            'branch_close' => $request->branch_close,
            'branch_contact' => $request->branch_contact,
            'day_open' => $request->branch_open_from.'-'.$request->branch_open_upto,

        ]);
        return redirect()->back()->with('message','Successfully updated a branch.');
    }

    public function destroy(Branch $branch)
    {
        //
    }

}
