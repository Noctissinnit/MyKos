<?php

namespace App\Models;

abstract class AbstractUserRole
{
    abstract public function dashboardRoute(): string;
    abstract public function permissions(): array;

    public function redirectToDashboard()
    {
        return redirect($this->dashboardRoute());
    }
}
