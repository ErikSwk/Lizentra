<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lizenz extends Model
{
    use HasFactory;

    protected $table = 'lizenzen';
    protected $primaryKey = 'lizenzschluessel';
    public $incrementing = false; // Da der Primärschlüssel kein Integer ist
    protected $keyType = 'string';

    protected $guarded = [];

    
    //Beziehung zum Sekretariat (User)
    public function sekretariat()
    {
        return $this->belongsTo(Sekretariat::class, 'sekretariat_id');
    }

    
    //Beziehung zu Computern (n:m)
    public function computer()
    {
        /* return $this->belongsToMany(Computer::class, 'computer_lizenz', 'lizenzschluessel', 'computer_id')
                ->using(ComputerLizenz::class)
                ->withTimestamps(); */

        return $this->belongsToMany(Computer::class, 'computer_lizenz', 'lizenzschluessel', 'computer_id') //Hier die Namen der Attribute wie in computer_lizenz Tabele
                    ->withTimestamps();
    }
}
