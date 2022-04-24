<?php

namespace Raosys\Fees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class FeeStructure extends Model
{
    use HasFactory, SoftDeletes;
    public function entry_items()
    {
        return $this->hasMany(EntryItem::class);
    }

    public function course()
    {
        return $this->belongsTo(is_array(config('fees.courses_model')) ? config('fees.courses_model')[intval(App::version())] : config('fees.courses_model'));
    }
}
