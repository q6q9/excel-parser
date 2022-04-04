<?php

namespace App\Http\Controllers;

use App\Models\Row;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RowsController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        $dates = Row::select(DB::raw('DATE_FORMAT(date, "%d.%m.%Y") as date'))
            ->groupBy(['date'])->pluck('date');

        $response = [];

        /** @var Carbon $date */
        foreach ($dates as $date) {
            $rows = DB::table('rows')->where('date', $date)->get([
                '*',
                DB::raw('DATE_FORMAT(date, "%d.%m.%Y") as date')
            ]);

            $response[$date->format('d.m.Y')] = $rows;
        }

        return $response;
    }
}
