<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
        ]);
        $dep = new Department([
            'name' => $request->department_name,
        ]);

        $dep->save();


        return response()->json([
            'message' => 'Successfully created department!'
        ], 201);


    }


    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|string',
        ]);
        $data= [
            "name" => $request->department_name,
        ];

        if (Department::find($request->id)->update($data)) {
            return response()->json([
                'message' => 'Successfully updated department!'
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $g = Department::find($request->id);
        if(isset($g)){
            $g->delete();
            return response()->json([
                'message' => 'Successfully deleted department!'
            ], 201);
        }else{
            return response()->json([
                'error' => 'Department Missing Create it !'
            ], 400);
        }
    }

}
