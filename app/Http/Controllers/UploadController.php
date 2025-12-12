<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function summernoteUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Save file inside public/uploads/summernote/
            $file->move(public_path('uploads/summernote'), $filename);

            // Return correct file URL
            return response()->json([
                'url' => asset('uploads/summernote/' . $filename)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
