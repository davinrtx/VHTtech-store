<?php

namespace App\Policies;

use App\Models\User;

class AttributePolicy
{
    public function viewAny(User $user): bool { return $user->can('manage catalog'); }
    public function view(User $user): bool { return $user->can('manage catalog'); }
    public function create(User $user): bool { return $user->can('manage catalog'); }
    public function update(User $user): bool { return $user->can('manage catalog'); }
    public function delete(User $user): bool { return $user->can('manage catalog'); }
}
