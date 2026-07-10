<?php

namespace App\Policies;

use App\Models\User;

class RepairOrderPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage repairs'); }
    public function view(User $user): bool { return $user->can('manage repairs'); }
    public function create(User $user): bool { return $user->can('manage repairs'); }
    public function update(User $user): bool { return $user->can('manage repairs'); }
    public function delete(User $user): bool { return $user->can('manage repairs'); }
}
