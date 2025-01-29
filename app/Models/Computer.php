<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $table = 'computer';

    protected $guarded = [];

    /**
     * Beziehung zum Sekretariat (User)
     */
    public function sekretariat()
    {
        return $this->belongsTo(Sekretariat::class, 'sekretariat_id');
    }

    /**
     * Beziehung zu Lizenzen (n:m)
     */
    public function lizenzen()
    {
        /* return $this->belongsToMany(Lizenz::class, 'computer_lizenz', 'computer_id', 'lizenzschluessel')
                ->using(ComputerLizenz::class)
                ->withTimestamps(); */

        return $this->belongsToMany(Lizenz::class, 'computer_lizenz', 'computer_id', 'lizenzschluessel')
                    ->withTimestamps();
    }
}
