<?php

namespace Raosys\Fees\Traits;

use Raosys\Fees\Models\FeeStructure;

trait CourseTrait
{

    /**
     * User's Parent FeeStrucure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fee_structures()
    {
        return $this->hasMany(FeeStructure::class)->withTrashed();
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
