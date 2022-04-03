<?php

namespace App\Imports;

use App\Events\Processing;
use App\Models\Row;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeImport;

class RowImport implements
    ToModel,
    WithStartRow,
    WithEvents,
    WithProgressBar,
    WithBatchInserts
{
    use Importable {
        getConsoleOutput as traitGetConsoleOutput;
    }

    /**
     * @var int
     */
    public $totalRows;

    /**
     * @var int
     */
    public $processedRows = 0;

    /**
     * @var
     */
    public $prevPercent;

    /**
     * @var string
     */
    public $channelID;

    /**
     * @param string $channelID
     */
    public function __construct($channelID)
    {
        $this->channelID = $channelID;
    }

    /**
     * @param array $row
     * @return Model
     */
    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return [];
        }

        return new Row([
            'name' => $row[1],
            'date' => date('Y-m-d H:i:s', ($row[2] - 25569) * 86400)
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->totalRows = Arr::first($event->getReader()->getTotalRows());

                $this->event();
            }
        ];
    }

    /**
     * @return OutputStyle
     */
    public function getConsoleOutput(): OutputStyle
    {
        $this->processedRows += $this->batchSize();

        $this->event();

        return $this->traitGetConsoleOutput();
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1;
    }

    /**
     * @return void
     */
    private function event()
    {
        $percent = $this->processedRows / $this->totalRows * 100;

        if ($percent === $this->prevPercent) {
            return;
        }

        $this->prevPercent = $percent;

        if ($percent > 100) {
            $percent = 100;
        }

        Processing::dispatch($percent, $this->channelID);
    }
}