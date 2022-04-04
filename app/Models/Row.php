<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $date
 */
class Row extends Model
{
    protected $fillable = [
        'name',
        'date'
    ];

    protected $dates = ['date'];

    public $timestamps = false;
}
