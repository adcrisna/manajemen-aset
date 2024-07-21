<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    use HasFactory;

    public function Aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'id');
    }
}
