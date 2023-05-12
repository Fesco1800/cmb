<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\LandingPageService;
class LandingPageServiceController extends Controller
{
    
    public function store(Request $request) {

        $validate = Validator::make($request->all(),[

            'title' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        if($validate->fails()) {

            return redirect()->back()->withErrors($validate);

        }

        LandingPageService::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->back()->with('message','Successfully created a service.');
    }

    public function update(Request $request, LandingPageService $service) {

        $validate = Validator::make($request->all(),[

            'title' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        if($validate->fails()) {

            return redirect()->back()->withErrors($validate);

        }

        $service->title = $request->title;
        $service->description = $request->description;
        $service->save();

        return redirect()->back()->with('message','Successfully updated a service.');
    }

    public function destroy(LandingPageService $service) {

        $service->delete();

        return redirect()->back()->with('message','Successfully deleted service');
    }
}
