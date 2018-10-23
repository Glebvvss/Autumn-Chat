<?php 

namespace App\Models\Traits\Scopes;

trait TGroupScopes {

    public function scopePublicType($query)
    {
        return $query->where('type', '=', 'public');
    }

}