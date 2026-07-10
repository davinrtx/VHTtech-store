<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage customers'); }
    public function view(User $user): bool { return $user->can('manage customers'); }
    public function create(User $user): bool { return $user->can('manage customers'); }
    public function update(User $user): bool { return $user->can('manage customers'); }
    public function delete(User $user): bool { return $user->can('manage customers'); }
}
