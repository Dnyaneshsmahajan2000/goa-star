<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExpenses;
use App\Models\Group;
use App\Models\Ledger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator as ValidationValidator;

class EmployeeExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empexp = EmployeeExpenses::all();
        return view('Employee_Expenses.index', compact('empexp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exp_categorys = Group::getAllLedgers([GROUP_DIRECT_EXPENSES, GROUP_INDIRECT_EXPENSES]);
                $employees = Group::getAllLedgers([GROUP_SALARY_PAYABLE]);

        $params['exp_categorys'] = $exp_categorys;
        $params['employees'] = $employees;

        return view('Employee_Expenses.create', $params);
    }

    public function verify_expense()
    {
        $employeeExpenses = DB::table('employee_expenses')
            ->select('*')
            ->WhereNull('is_verified')
            ->get();

        return view('Employee_Expenses.verify_expense', compact('employeeExpenses'));
    }
    public function verify_employee_expense($id)
    {
        $exp_categorys = Group::getAllLedgers([GROUP_DIRECT_EXPENSES, GROUP_INDIRECT_EXPENSES]);

        $employeeExpenses = DB::table('employee_expenses')
            ->where('id', $id)->first();
        return view('Employee_Expenses.emp-expense-verify', compact('employeeExpenses', 'exp_categorys'));
    }
    public function verify_employee_expense_save(Request $request, $id)
    {
        $employeeExpenses = DB::table('employee_expenses')
            ->select('*')
            ->WhereNull('is_verified')
            ->get();
        $employeeExpenses_data = EmployeeExpenses::find($id);
        $employeeExpenses_data->approved_amount = $request['approve_amount'];
        $employeeExpenses_data->exp_category = $request['exp_category'];
        $employeeExpenses_data->is_verified = $request['is_verified'];
        $employeeExpenses_data->reason = $request['reason'];
        $employeeExpenses_data->save();
        return view('Employee_Expenses.verify_expense', compact('employeeExpenses'))->with("success", 'Updated Successfully');;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'

        ]);

        try {
            $empexp = new EmployeeExpenses();
            $empexp->date = session('date');
            $empexp->amount = $request->amount;
            if (auth()->user()->role->name == 'Admin') {
                $empexp->approved_amount = $request->amount;
                $empexp->exp_category = $request->exp_category;
                $empexp->is_verified = 'verified';
                $empexp->verified_on = now();
                $empexp->emp_id = $request->emp_id;
            } else {

                $empexp->exp_category = NULL; // Replace 'default_category' with an appropriate default value
                $empexp->emp_id = auth()->id();
            }
            if ($request->hasFile('file')) {
                if ($empexp->file && file_exists(public_path($empexp->file))) {
                    unlink(public_path($empexp->file));
                }
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Move file to the 'public/uploads' directory
                $empexp->file = 'uploads/' . $fileName; // Save the relative path to the database
            }
            $empexp->details = $request->details;
            $empexp->created_by = auth()->id();
            $empexp->updated_by = auth()->id();

            $empexp->created_at = now();
            $empexp->updated_at = now();
            $empexp->save();

            return redirect()->route('emp-expenses.index')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(EmployeeExpenses $employeeExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function expense_edit($id)
    {
        $empexp = EmployeeExpenses::find($id);
        $exp_categorys = Group::getAllLedgers([GROUP_DIRECT_EXPENSES, GROUP_INDIRECT_EXPENSES]);
        $employees = Group::getAllLedgers([GROUP_SALARY_PAYABLE]);

        $params['exp_categorys'] = $exp_categorys;
        $params['employees'] = $employees;
        $params['empexp'] = $empexp;
        $params['id'] = $id;
        return view('Employee_Expenses.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function expense_update(Request $request, $id)
    {
        $empexp = EmployeeExpenses::find($id);

        try {
            $empexp->date = session('date');
            $empexp->amount = $request->amount;
            if (auth()->user()->role->name == 'Admin') {
                $empexp->approved_amount = $request->amount;
                $empexp->exp_category = $request->exp_category;
                $empexp->is_verified = 'verified';
                $empexp->verified_on = now();
                $empexp->emp_id = $request->emp_id;
            } else {

                $empexp->exp_category = 0;
                $empexp->emp_id = auth()->id();
            }
            if ($request->hasFile('file')) {
                if ($empexp->file && file_exists(public_path($empexp->file))) {
                    unlink(public_path($empexp->file));
                }
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Move file to the 'public/uploads' directory
                $empexp->file = 'uploads/' . $fileName; // Save the relative path to the database
            }
            $empexp->details = $request->details;
            $empexp->created_by = auth()->id();
            $empexp->updated_by = auth()->id();

            $empexp->created_at = now();
            $empexp->updated_at = now();
            $empexp->save();

            return redirect()->route('emp-expenses.index')->with('success', 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function expense_destory($id)
    {
        $employeeExpenses = EmployeeExpenses::where('id', $id)->first();
        if ($employeeExpenses) {
            $employeeExpenses->delete();
            return redirect()->route('emp-expenses.index')->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Record not found');
        }
    }
}
