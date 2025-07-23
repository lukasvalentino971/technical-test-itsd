<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementItems extends Model
{
    use HasFactory;

    // table_name procurement_items

    protected $table = 'procurement_items';

    protected $fillable = [
        'procurement_id', 'product_id', 'qty', 'price', 'subtotal'
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurements::class, 'procurement_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
