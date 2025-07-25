<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurements extends Model
{
    use HasFactory;

    protected $table = 'procurements';

    protected $fillable = [
        'title', 'total_price',
    ];

    public function items()
    {
        return $this->hasMany(ProcurementItems::class, 'procurement_id');
    }
}
