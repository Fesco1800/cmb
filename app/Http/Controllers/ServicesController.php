<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function index(Branch $branch)
    {
        
        $services= Services::query()
                ->where('branch_id',$branch->id)
                ->orderBy('id','DESC')
                ->paginate(10);
        
        return view('admin.branches.services.index', [

            'services' => $services,
            'branch' => $branch

        ]);
    }

    public function create(Branch $branch)
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }
        
        return view('admin.branches.services.create', [

            'branch' => $branch
            
        ]);
    }

  
    public function store(Request $request, Branch $branch)
    {

        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        $validate = Validator::make($request->all(),[

            'service_name' => 'required|string|max:250',
            'service_price' => 'required|string|max:12',
            'service_detail' => 'required|string|max:500',

        ]);

        if($validate->fails()){

            return redirect()->back()->withErrors($validate);
        }

        $service = Services::create([

            'service_name' => $request->service_name,
            'service_price' => $request->service_price.'.00',
            'service_detail' => $request->service_detail,
            'minutes' => $request->minutes,
            'branch_id' => $branch->id,
            'isMainService' => $request->isMainService,
            'user_id' => auth()->user()->id,

        ]);

        if ($request->hasFile('service_img')) {
            $image = $request->service_img;
            $service_img = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/services'),$service_img);

            $service =  Services::find($service->id);
            $service->service_img = $service_img;
            $service->save();
        }

        return redirect()->back()->with('message','Successfully added a service.');

    }

    public function show(Services $services)
    {
        //
    }

    public function edit(Services $service)
    {
       
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }
        
        return view('admin.branches.services.edit', [

            'service' => $service
            
        ]);
    }

    public function update(Request $request, Services $service)
    {
        if(auth()->user()->role != 'Admin') {

            return redirect()->back()->with('warning','Unauthorized action.');
        }

        Services::findOrfail($service->id)->update([

            'service_name' => $request->service_name,
            'service_price' => $request->service_price,
            'service_detail' => $request->service_detail,
            'minutes' => $request->minutes,
            'isMainService' => $request->isMainService,

        ]);

        if ($request->hasFile('service_img')) {
            $image = $request->service_img;
            $service_img = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/services'),$service_img);

            $service->service_img = $service_img;
            $service->save();
        }

        return redirect()->back()->with('message','Successfully updated a service.');
    }

    public function destroy(Services $service)
    {
        Services::findOrfail($service->id)->delete();

        return redirect()->back()->with('message','Successfully deleted a service.');
    }
    public function changeStatus(Services $service)
    {

        Services::findOrfail($service->id)->update([
            
            'isAvailable' => $service->isAvailable =! $service->isAvailable,

        ]);

        return redirect()->back()->with('message','Successfully updated a status.');

    }
}
