<?php

namespace App\Models\Roles;

use App\Models\AbstractUserRole;

class PemilikRole extends AbstractUserRole
{
    public function dashboardRoute(): string
    {
        return '/pemilik/dashboard';
    }

    public function permissions(): array
    {
        return ['manage_kos', 'manage_rooms'];
    }
}
