<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
   
    public function addBarber(Branch $branch)
    {
        $barbers = User::query()
            ->with('hasBranch')
            ->where('role','Barber')
            ->get();

        $barbersList = Employee::query()
            ->where('branch_id', $branch->id)
            ->get();

        return view('admin.branches.barbers.create', [

            'branch' => $branch,
            'barbers' => $barbers,
            'barbersList' => $barbersList

        ]);


    }

    public function create()
    {
        //
    }

    public function store(Request $request, Branch $employee)
    {
        Employee::create([

            'branch_id' => $employee->id,
            'user_id' => auth()->user()->id,
            'barber_id' => $request->barber
        ]);
        return redirect()->back()->with('message','Successfully added a barber in branch number '.$employee->branch_number);
    }

    public function destroy(Employee $barber)
    {
        Employee::findOrfail($barber->id)->delete();

        return redirect()->back()->with('message','Successfully remove a barber');
    }
}
