<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employeeId, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $attendance = Attendance::where('employeeid', $employeeId)
            ->whereBetween('entrytimestamp', [$request->start_date, $request->end_date])
            ->get();

        return response()->json(['attendance' => $attendance], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(
        // [
        //     'employee_id' => 'required|exists:employees,id',
        //     'date' => 'required|date',
        //     'status' => 'required|in:present,absent,late',
        // ]
            [
                'employeeid'=>'required|exists:staffdetails,employeeid',
                'empLocation'=>'required',
                'empattendancestatus'=>'required',
                'empattendancedate'=>'required',
            ]
        );

        $employee = Employee::findOrFail($data['employeeid']);

        $attendance = new Attendance([
            'employeeid'=>$employee->employeeid,
            'empLocation'=>$data['empLocation'],
            'empattendancestatus'=>$data['empattendancestatus'],
            'empattendancedate'=>$data['empattendancedate'],
            "entryip"=> $request->entyip,
            "entrycity"=> $request->entrycity
        ]);

        $attendance->save();

        return response()->json(['message' => 'Attendance stored successfully', 'attendance' => $attendance], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
