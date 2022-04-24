<?php

namespace Raosys\Fees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_structure_id',
        'votehead',
        'amount',
    ];


    public function fee_structure()
    {
        return $this->belongsTo(FeeStructure::class)->withTrashed();
    }
}
