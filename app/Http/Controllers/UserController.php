<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeePermission;
use App\Models\User;
use App\Models\Group;
use App\Models\UserRole;
use App\Models\Godown;
use App\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        // $roles = UserRole::all();
        // $godowns = Godown::all();
        //return ($users);
        return view('users.index', compact('users'));
    }

    public function emp_attendance()
    {

        return view('users.emp-attendance');
    }
    public function emp_attendance_save(Request $request)
    {
        $selected_date = $request->date;
        $users = DB::table('users')
            ->whereIn('role_id', [2, 4])
            ->get();
        return view('users.emp-attendance', compact('users', 'selected_date'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        return $user = User::user($id);
        $user->passord;
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.index')->with('success', 'Password updated successfully. Please log in with your new password.');
    }



    public function changePassword($id)
    {
        $user = User::find($id);
        return view('users.change-password', compact('user'));
    }

    public function block(Request $request, $id)
    {
        $user = User::find($id);
        $user->is_blocked = true;
        $user->save();
        return redirect()->route('user.index')->with('status', 'User blocked successfully!');
    }
    public function unblock(Request $request, $id)
    {
        $user = User::find($id);
        $user->is_blocked = false;
        $user->save();
        return redirect()->route('user.index')->with('status', 'User Unblocked successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function permission($id)
    {
        $access = [
            'Home' => ['add' => 0, 'update' => 0],
            'Masters' => ['add' => 0, 'update' => 0],
            'Ledgers' => ['add' => 0, 'update' => 0],
            'Employee' => ['add' => 0, 'update' => 0],
            'Expenses_Categories' => ['add' => 0, 'update' => 0],
            'Journal' => ['add' => 0, 'update' => 0],
            'Godown' => ['add' => 0, 'update' => 0],
            'Sale' => ['add' => 0, 'update' => 0],
            'Purchase' => ['add' => 0, 'update' => 0],
            'Machines' => ['add' => 0, 'update' => 0],
            'Sale_Return' => ['add' => 0, 'update' => 0],
            'Purchase_Return' => ['add' => 0, 'update' => 0],
            'Receipt' => ['add' => 0, 'update' => 0],
            'Expenses' => ['add' => 0, 'update' => 0],
            'Payment' => ['add' => 0, 'update' => 0],
            'Reports' => ['add' => 0, 'update' => 0],
            'Order' => ['add' => 0, 'update' => 0],
            'Stock_journal' => ['add' => 0, 'update' => 0],
            'Groups' => ['add' => 0, 'update' => 0],
            'Item_Groups' => ['add' => 0, 'update' => 0],
            'Item_Category' => ['add' => 0, 'update' => 0],
            'Items(Finish Good/Raw Material)' => ['add' => 0, 'update' => 0],
            'Employee_Expenses' => ['add' => 0, 'update' => 0],
            'Employee_Attendance' => ['add' => 0, 'update' => 0],
            'Verfiy_Employee_Expenses' => ['add' => 0, 'update' => 0],
            'Generate_Employee_Salary' => ['add' => 0, 'update' => 0],
            'Manufacturing' => ['add' => 0, 'update' => 0],
            'Day_Report' => ['add' => 0],
            'Ledger_Report' => ['add' => 0],
            'Group_Report' => ['add' => 0],
            'Godown_Wise_Stock_Report' => ['add' => 0],
            'Minimum_Stock_Qty_Report' => ['add' => 0],
            'Sale_Report' => ['add' => 0],
            'Sale_Return_Report' => ['add' => 0],
            'Purchase_Report' => ['add' => 0],
            'Purchase_Return_Report' => ['add' => 0],
            '30_Days_debtors_Report' => ['add' => 0],
            'Sale_Order_Difference_Report' => ['add' => 0],
            'Inactive_Customer' => ['add' => 0],
            'Receivable_Report' => ['add' => 0],
            'Payable_Report' => ['add' => 0],
            'Item_Wise_Stock_Report' => ['add' => 0],
            'Payment_Report' => ['add' => 0],
            'Receipt_Report' => ['add' => 0],
            'Bank_Balance_Report' => ['add' => 0],
            'Order_Summary_Report' => ['add' => 0],
            'Order_Report' => ['add' => 0],
            'voucher_Report' => ['add' => 0],

            'Highest_Customer_Report' => ['add' => 0]

        ];
        $user = User::find($id);
        $permissions = unserialize($user->permission);
        return view('users.employee-permission', ['access' => $access, 'id' => $id, 'permissions' => $permissions]);
    }

    public function create()
    {

        $users = User::all();
        $roles = UserRole::all();
        $godowns = Godown::all();
        return view('users.create', compact('roles', 'godowns'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|min:10|max:10',
            'dob' => 'required',
            'gender' => 'required|in:male,female',
            'type' => 'required|in:admin,master,agent,user',
            'address' => 'nullable',
            'details' => 'nullable',
            'salary' => 'nullable',
            'password' => 'nullable',
            'can_login' => 'nullable',

        ]);
        try {
            $user = new user();
            // $user->salary->$request->salary;
            $user->name = ucwords($request['name']);
            $user->address = $request['address'] ?? null;
            $user->details = $request['details'] ?? null;
            $user->mobile = $request['mobile'];
            $user->gender = $request['gender'];
            $user->type = $request['type'];
            $user->can_login = $request['can_login'];
            $user->dob = $request['dob'];
            $user->salary = $request['salary'];
            $user->password = bcrypt($request['password']);
            $user->save();
            return redirect()->route('user.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", 'Error occurred: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }
    public function reset_password($id)
    {
        $user = User::find($id);
        $user->password = Hash::make($user->mobile);
        $user->save();

        return redirect()->route('user.index')->with('success', 'Password reset to mobile number successfully.');
    }

    public function reset_mpin($id)
    {
        $user = User::find($id);
        $user->pin = null;
        $user->save();

        return redirect()->route('user.index')->with('success', 'MPIN reset successfully.');
    }
    public function user_block($id)
    {
        $user = User::find($id);
        if (Schema::hasColumn('users', 'deleted_at')) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User blocked and MPIN reset successfully.');
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'MPIN reset successfully.');
    }
    public function permission_save(Request $request, $id)
    {
        $user = User::find($id);
        $user->permission = serialize($request->access);
        $user->save();

        return redirect()->route('user.index')->with('success', 'Permission Save Successfully.');
    }

    public function edit(string $id)
    {
        $user = user::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|min:10|max:10',
            'email' => 'nullable|max:50', // Make email field nullable
            'gender' => 'required|in:male,female',
            'role_id' => 'required',
            'gd_id' => 'required|integer',
            'salary' => 'nullable',
            'password' => 'nullable',

            'can_login' => 'nullable',

        ]);
        try {


            // Find the Employee instance by ID
            $user = user::find($id);

            // Update Employee instance with validated data
            $user->name = ucwords($request['name']);
            $user->mobile = $request['mobile'];
            $user->email = $request['email'];


            $user->gender = $request['gender'];
            $user->role_id = $request['role_id'];
            $user->can_login = $request['can_login'];
            $user->gd_id = $request['gd_id'];
            $user->salary = $request['salary'];

            $user->password = bcrypt($request['password']);
            $user->save();
            $ledger = Ledger::where('ref_id', $id)->first();
            $ledger->name = $request['name'];
            $ledger->mobile = $request['mobile'];
            $ledger->email = $request['email'];
            $ledger->state = "";
            $ledger->gd_id = GROUP_SALARY_PAYABLE;
            $ledger->gd_id = $request['gd_id'];
            $ledger->save();
            return redirect()->route('user.index')->with("success", 'Updated Successfully');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with("error", 'Error occurred: ' . $e->getMessage())->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = user::find($id);
        $user->delete();
        return redirect()->route('user.index')->with("success", 'Deleted successfully');
    }
}
