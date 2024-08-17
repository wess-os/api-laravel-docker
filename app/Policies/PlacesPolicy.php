<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacesPolicy
{
    public function modify(User $user, Place $place): Response
    {
        //
    }
}
