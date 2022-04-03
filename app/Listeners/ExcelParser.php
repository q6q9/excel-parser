<?php

namespace App\Listeners;

use App\Events\ExcelParsing;
use App\Imports\RowImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ExcelParser implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ExcelParsing $excelParsing
     * @return void
     */
    public function handle($excelParsing)
    {
//        exit();
        $file = new UploadedFile($excelParsing->pathToExcel, '');
//        $file = new UploadedFile(
//            Storage::path('uploads/d50091f5-69ba-4c92-9dbe-44b87ded710c.xlsx')
//            , '');

        Excel::import(new RowImport($file->getFilename()), $file->getRealPath());
    }
}
