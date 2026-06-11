<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function projectImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('project-images', 'public');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'url' => asset('storage/' . $path),
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }
}
