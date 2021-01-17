<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'name' => 'required|string',
            'course_id' => 'required|integer',
        ]);
        $file = new File([
            'name' => $request->name,
        ]);
        $file->path = $request->file->getClientOriginalName();
        $request->file->storeAs('files', $file->path);


        $file->user()->associate($request->user()->id);

        $file->course()->associate($request->course_id);

        $file->save();

        return response()->json([
            'message' => 'Successfully created file!'
        ], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'name' => 'required|string',
            'course_id' => 'required|integer',
        ]);

        $file = File::find($request->id);

        $file->name = $request->name;
        $file->path = $request->file->getClientOriginalName();
        $request->file->storeAs('files', $file->path);

        $file->update();

        return response()->json([
            'message' => 'Successfully updated file!'
        ], 201);
    }

    public function delete(Request $request){
        $file = File::find($request->id);
        if(isset($file)){
            $file->delete();
            return response()->json([
                'message' => 'Successfully deleted file!'
            ], 201);
        }else{
            return response()->json([
                'error' => 'File Missing Create it !'
            ], 400);
        }
    }


    public function download(Request $request)
    {
        // dd($request->id);
        $file = File::where('id', $request->id)->firstOrFail();
        $pathToFile = storage_path('app/files/' . $file->path);
        // dd($pathToFile);
        // return response()->download($pathToFile);

        return response()->json([
            'path' => $pathToFile
        ], 201);
    }
}
