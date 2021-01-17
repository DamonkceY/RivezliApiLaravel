<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'group_id' => 'required|integer',
        ]);
        $course = new Course([
            'name' => $request->name,
        ]);

        $group = Group::find($request->group_id);

        $course->user()->associate($request->user()->id);
        $course->group()->associate($group);
        $course->save();

        return response()->json([
            'message' => 'Successfully created course!'
        ], 201);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string'
        ]);

        $data = [
            'name' => $request->name
        ];

        $course = Course::find($request->id);
        if($course->update($data)){
            return response()->json([
                'message' => 'Successfully updated course!'
            ], 201);
        }
    }

    public function delete(Request $request){
        $course = Course::find($request->id);
        if(isset($course)){
            $course->delete();
            return response()->json([
                'message' => 'Successfully deleted course!'
            ], 201);
        }else{
            return response()->json([
                'error' => 'Course Missing Create it !'
            ], 400);
        }
    }

}
