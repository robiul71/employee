<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendence;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (request()->ajax()) {
            $data = Attendence::latest()->get();
            return DataTables::of($data)

            ->editColumn('employee_id',function ($data) {
                return $data->employee->name;
            })
            ->editColumn('date',function ($data) {
                return $data->date->format('d-M-Y');
            })
            ->editColumn('clock_in',function ($data) {
                return $data->clock_in;

            })
            ->editColumn('clock_out',function ($data) {
                return $data->clock_out;
            })


                ->addColumn('action', function ($data) {
                    $edit = '<button  class="btn btn-sm btn-primary show-modal" data-url="' . route('attendance.edit', $data->id) . '" ><i class="fa fa-edit"></i> Edit</button>
                    <button  class="btn btn-danger btn-sm show-modal" data-url ="' . route('attendance.delete', $data->id) . '"><i class="fa fa-trash"></i> Delete</button>';
                    return $edit;
                })
                ->addColumn('checkbox',function($data){
                    $checkbox=  '<input type="checkbox" name="checkbox" class"checkbox" data-id="'.$data['id'].'" >';
                    return $checkbox;
                  })
                ->rawColumns([ 'employee_id','date','clock_in','clock_out','action','checkbox'])
                ->toJson();
        }

        return view('admin.pages.attendance.index');
    }


    public function create()
    {
        return view('admin.pages.attendance.create',[
            'employess'=>Employee::latest()->get()
        ]);
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'employee_id' => 'required',
            'date' => 'required',
            'clock_in' => 'required',
            'clock_out' => 'required',


        ]);
        if ($validation->fails()) {
            return response()->json(['msg' => 'Something went to wrong']);
        } else {

               Attendence::insert($request->except('_token'));

            return response()->json(['success' => true, 'msg' => 'Employee attentdance created successfully']);
        }
    }



    public function edit(Attendence $employee_attendance)
    {
        $employess=Employee::latest()->get();
        return view('admin.pages.attendance.edit', compact('employee_attendance','employess'));
    }


    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'employee_id' => 'required',
            'date' => 'required',
            'clock_in' => 'required',
            'clock_out' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => false, 'msg' => 'Something went to wrong']);
        } else {
            Attendence::findOrFail($id)->update([
                'employee_id' => $request->employee_id,
                'date'=>$request->date,
                'clock_in'=>$request->clock_in,
                'clock_out'=>$request->clock_out,
                'updated_at' => Carbon::now()
            ]);
            return response()->json(['success' => true, 'msg' =>'Employee attentdance updated successfully']);
        }
    }

    public function delete($id)
    {
        return view('admin.pages.attendance.delete', compact('id'));
    }
    public function destroy(Attendence $employee_attendance)
    {
        $employee_attendance->delete();
        return response()->json(['success' => true, 'msg' =>  'Employee attendance deleted successfully']);
    }

    public function delete_all(Request $request)
    {
        $ids = $request->input('checked_id');
        return view('admin.pages.attendance.delete-all', compact('ids'));
    }

    public function destroy_all(Request $request)
    {
        $id_array = $request->input('ids');
        foreach($id_array as $id){
           $employee_attendance = Attendence::find($id);
           $employee_attendance->delete();
        }
        return response()->json(['success' => true, 'msg' =>  'Employee attendance  Bulk deleted successfully']);
    }
}
