<?php

namespace App\Policies;

use App\Models\ProductVariant;
use App\Models\User;

class VariantPolicy
{
    public function manage(User $user): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, ProductVariant $variant): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, ProductVariant $variant): bool
    {
        return $user->is_admin;
    }
}
