<?php

namespace App\Http\Controllers;

use App\Models\Row;

class RowsController extends Controller
{
    public function index()
    {
        return Row::all();
    }
}
