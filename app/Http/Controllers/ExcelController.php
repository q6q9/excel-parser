<?php

namespace App\Http\Controllers;

use App\Events\ExcelParsing;
use App\Http\Requests\ExcelRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExcelController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function upload(ExcelRequest $request)
    {
        $validated = $request->validated();

        /** @var UploadedFile $excel */
        $excel = Arr::get($validated, 'excel');

        $name = Str::uuid() . '.' . $excel->extension();

        $path = Storage::disk('local')->putFileAs(
            'uploads',
            $excel,
            $name
        );

        ExcelParsing::dispatch(Storage::path($path));

        return response()->json(['channel' => $name]);
    }
}
