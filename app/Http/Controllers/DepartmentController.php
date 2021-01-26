<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $dep = new Department([
            'name' => $request->name,
        ]);

        $dep->save();


        return response()->json([
            'dep' => $dep
        ], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $data = [
            "name" => $request->name,
        ];


        if (Department::find($request->id)->update($data)) {
            return response()->json([
                'message' => 'Successfully updated department!'
            ], 201);
        }
    }

    public function delete(Request $request)
    {
        $g = Department::find($request->id);

        if (isset($g)) {
            $g->delete();
            return response()->json([
                'message' => 'Successfully deleted department!'
            ], 201);
        } else {
            return response()->json([
                'error' => 'Department Missing Create it !'
            ], 400);
        }
    }
}
