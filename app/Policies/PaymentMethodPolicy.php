<?php

namespace App\Policies;

use App\Models\User;

class PaymentMethodPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage settings'); }
    public function view(User $user): bool { return $user->can('manage settings'); }
    public function create(User $user): bool { return $user->can('manage settings'); }
    public function update(User $user): bool { return $user->can('manage settings'); }
    public function delete(User $user): bool { return $user->can('manage settings'); }
}
