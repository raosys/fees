<?php

namespace Raosys\Fees\Traits;

use App\Models\User;

trait StudentTrait
{

    /**
     * User's Parent FeeStrucure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Course attributes.
     *
     * @return object
     */
    public function attributes()
    {
        return (object) $this->attributes;
    }
}
