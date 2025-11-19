<?php

namespace App\Models\Roles;

use App\Models\AbstractUserRole;

class AdminRole extends AbstractUserRole
{
    public function dashboardRoute(): string
    {
        return '/admin/dashboard';
    }

    public function permissions(): array
    {
        return ['manage_users', 'manage_rooms', 'manage_payments'];
    }
}
