<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        // return view('logs.index');

        $files = Storage::files($directory);
    }

}
