<?php

namespace App\Http\Controllers;

use App\Models\Workscript\File;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        return view('logs.index');
    }

    public function data()
    {
        $files = new File();
        $files->reset();

        return json_encode(
                    $files->addDir( storage_path('logs/') )
                                ->recursive( $subdir = false )
                                ->addFile('error_log')
                                ->addFile('error_log.log')
                                ->addExtension('log')
                                ->search()
        );
    }
}
