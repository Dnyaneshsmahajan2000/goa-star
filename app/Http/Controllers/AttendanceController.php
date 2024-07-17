<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function saveAttendance(Request $request)
    {
        $date = $request->input('date');
        $attendances = collect($request->input('attendance', []));
        $userId = auth()->id();

        Attendance::whereIn('emp_id', $attendances->keys())->where('date', $date)->delete();

        // Prepare the data for bulk insertion
        $data = $attendances->map(function ($status, $emp_id) use ($date, $userId) {
            return [
                'emp_id' => $emp_id,
                'date' => $date,
                'attendance' => $status,
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        // Perform bulk insertion
        Attendance::insert($data->toArray());

        // Fetch users with roles 2 and 4
        $users = DB::table('users')
            ->whereIn('role_id', [2, 4])
            ->get();

        // Pass the date, selected date, users, and success message to the view
        return view('users.emp-attendance')
            ->with([
                'date' => $date,
                'selected_date' => $date,
                'users' => $users,
                'success' => 'Attendance saved successfully.'
            ]);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(attendance $attendance)
    {
        //
    }
}
