<?php

namespace App\Models\Roles;

use App\Models\AbstractUserRole;

class UserRole extends AbstractUserRole
{
    public function dashboardRoute(): string
    {
        return '/user/dashboard';
    }

    public function permissions(): array
    {
        return ['choose_room', 'make_payment'];
    }
}
