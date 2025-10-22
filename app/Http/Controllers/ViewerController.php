<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function show($fileId)
    {
        return view('skosviewer', ['fileId' => $fileId]);
    }
}
