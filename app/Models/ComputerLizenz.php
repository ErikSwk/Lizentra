<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ComputerLizenz extends Pivot
{
    protected $table = 'computer_lizenz';

    protected $fillable = [
        'computer_id',
        'lizenzschluessel',
    ];
}
