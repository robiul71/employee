<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (request()->ajax()) {
            $data = Employee::latest()->get();
            return DataTables::of($data)
            ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" width="100px" height="50px" alt="">';
            })
            ->editColumn('name',function ($data) {
                return $data->name;
            })
            ->editColumn('email',function ($data) {
                return $data->email;
            })
            ->editColumn('age',function ($data) {
                return $data->age;
            })
            ->editColumn('gender',function ($data) {
                return $data->gender;
            })
            ->editColumn('hobbies',function ($data) {
                return json_decode( $data->hobbies);
            })
            ->editColumn('birth',function ($data) {
                return $data->birth->format('d F Y');
            })
                ->editColumn('status', function ($data) {
                    $button = 'btn-danger';
                    if ($data->status == 0) {
                        $button = 'btn-success';
                    }
                    $html = '<select class="btn-sm btn ' . $button . ' status-change" data-name="status" data-url="' . route('employee.status', $data->id) . '">
                  <option value="1" ' . ($data->status == 1 ? "selected" : "") . '>Deactive</option>
                  <option value="0"' . ($data->status == 0 ? "selected" : "") . '>Active</option>
                </select>';
                    return  $html;
                })

                ->addColumn('action', function ($data) {
                    $edit = '<button  class="btn btn-sm btn-primary show-modal" data-url="' . route('employee.edit', $data->id) . '" ><i class="fa fa-edit"></i> Edit</button>
                    <button  class="btn btn-danger btn-sm show-modal" data-url ="' . route('employee.delete', $data->id) . '"><i class="fa fa-trash"></i> Delete</button>';
                    return $edit;
                })
                ->addColumn('checkbox',function($data){
                    $checkbox=  '<input type="checkbox" name="checkbox" class"checkbox" data-id="'.$data['id'].'" >';
                    return $checkbox;
                  })
                ->rawColumns([ 'image','name','email','age','gender','hobbies','status','birth','action','checkbox'])
                ->toJson();
        }

        return view('admin.pages.employee.index');
    }


    public function create()
    {
        return view('admin.pages.employee.create');
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'image' => 'required',
            'name' => 'required',
            'email' => 'required|unique:employees,email|email',
            'age' => 'required|numeric',
            'gender' => 'required',
            'hobbies' => 'required',
            'birth' => 'required',

        ]);
        if ($validation->fails()) {
            return response()->json(['msg' => 'Something went to wrong']);
        } else {

               Employee::create([
               'image' => $request->image,
               'name'=>$request->name,
               'slug'=>Str::slug($request->name),
               'email'=>$request->email,
               'age'=>$request->age,
               'gender'=>$request->gender,
               'hobbies'=>json_encode($request->hobbies),
               'birth'=>$request->birth,
               'created_at'=>Carbon::now()
          ]);

            return response()->json(['success' => true, 'msg' => 'Employee Created Successfully']);
        }
    }


    public function status(Request $request, $id)
    {
        Employee::find($id)->update($request->all());
        return response()->json(['success' => true, 'msg' =>'Employee Status changes Successfully']);
    }


    public function edit(Employee $admin_employee)
    {
        return view('admin.pages.employee.edit', compact('admin_employee'));
    }


    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'required',
            'name' => 'required',
            'email' => 'required|unique:employees,email,'.$id,
            'age' => 'required|numeric',
            'gender' => 'required',
            'hobbies' => 'required',
            'birth' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => false, 'msg' => 'Something went to wrong']);
        } else {
            Employee::findOrFail($id)->update([
                'image' => $request->image,
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'email'=>$request->email,
                'age'=>$request->age,
                'gender'=>$request->gender,
                'hobbies'=>json_encode($request->hobbies),
                'birth'=>$request->birth,
                'updated_at' => Carbon::now()
            ]);
            return response()->json(['success' => true, 'msg' =>'Employee updated successfully']);
        }
    }

    public function delete($id)
    {
        return view('admin.pages.employee.delete', compact('id'));
    }
    public function destroy(Employee $admin_employee)
    {
        $admin_employee->delete();
        return response()->json(['success' => true, 'msg' =>  'Employee deleted successfully']);
    }

    public function delete_all(Request $request)
    {
        $ids = $request->input('checked_id');
        return view('admin.pages.employee.delete-all', compact('ids'));
    }

    public function destroy_all(Request $request)
    {
        $id_array = $request->input('ids');
        foreach($id_array as $id){
           $employee = Employee::find($id);
           $employee->delete();
        }
        return response()->json(['success' => true, 'msg' =>  'Employee Bulk deleted successfully']);
    }
}
