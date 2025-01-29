<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekretariat extends Model
{
    use HasFactory;

    protected $table = 'sekretariat';
    protected $primaryKey = 'SekretariatID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['SekretariatID', 'Lehrstuhl', 'Email', 'FakultÃ¤t'];

    public function users()
    {
        return $this->hasMany(User::class, 'SekretariatID', 'SekretariatID');
    }

    public function lizenzen(): HasMany
    {
        return $this->hasMany(Lizenz::class, 'sekretariat_id');
    }

    public function computer()
    {
        return $this->hasMany(Computer::class, 'sekretariat_id', 'SekretariatID');
    }
}
