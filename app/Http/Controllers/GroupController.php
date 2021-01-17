<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getAll(){
        return response()->json([
            'groups'=> Group::all()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string',
            'department_id' => 'required|integer',
        ]);
        $group = new Group([
            'name' => $request->group_name,
        ]);
        $dep = Department::find($request->department_id);

        $group->department()->associate($dep);
        $group->save();

        return response()->json([
            'message' => 'Successfully created group!'
        ], 201);
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'group_name' => 'required|string',
            'department_id' => 'required|integer',
        ]);

        $data = [
            "name" => $request->group_name,
            'department_id' => $request->department_id,
        ];
        if (Department::find($request->dpartment_id)) {
            $group = Group::find($request->id);
            $group->department()->dissociate();
            $group->department()->associate(Department::find($request->department_id));


            if ($group->update($data)) {
                return response()->json([
                    'message' => 'Successfully updated department!'
                ], 201);
            }
        }else{
            return response()->json([
                'error' => 'Department Missing Create it !'
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        $g = Group::find($request->id);
        if(isset($g)){
            $g->delete();
            return response()->json([
                'message' => 'Successfully deleted group!'
            ], 201);
        }else{
            return response()->json([
                'error' => 'Group Missing Create it !'
            ], 400);
        }
    }
}
