<?php

namespace Tests\Unit;

use App\Events\ExcelParsing;
use App\Models\Row;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExcelParserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_parser_is_working()
    {
        Row::truncate();

        $file = new UploadedFile(Storage::disk('tests')->path('/tests/excel/rows.xlsx'), '');

        ExcelParsing::dispatch($file->getRealPath());

        self::assertTrue(2474 === Row::count());
    }
}
