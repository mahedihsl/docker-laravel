<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class ExcelController extends Controller
{
    public function testImport(Request $request)
    {
        return Excel::load($request->file('sheet'))
            ->get()
            ->map(function($row) {
                return $row->get('first_name');
            })
            ->filter(function($name) {
                return !is_null($name);
            });
    }
}
