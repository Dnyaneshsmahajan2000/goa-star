<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $company = Company::first();

        return view('company.index', compact('company'));
    }
    public function change_password()
    {

        return view('company.change-password');
    }
    public function change_password_save(Request $request)
    {


        // Get the current user
        $user_data = Auth::user();

        $user = User::find($user_data->id);

        if ($request->new_password == $request->confirm_password) {

            // Update the user's password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Redirect the user with success message
            return redirect()->route('home')->with('success', 'Password changed successfully.');
        } else {
            return redirect()->with('Error', 'Password Not Match.');
        }
    }

    public function edit($id)
    {

        $company = Company::find($id);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $company->company_name = ucwords($request->company_name);
        $company->mobile = $request->mobile;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->city = $request->city;
        $company->state = $request->state;
        $company->pincode = $request->pincode;
        $company->fy_start_date = $request->fy_start_date;
        $company->fy_end_date = $request->fy_end_date;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/images');
            $company->logo =  $path;
        }

        $company->save();

        return redirect()->route('company.edit', $company->id)->with("success", 'Updated Successfully');
    }
}
