<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Roles\AdminRole;
use App\Models\Roles\PemilikRole;
use App\Models\Roles\UserRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'banned',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang dikonversi tipenya
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 🔹 Abstraksi untuk mendapatkan instance Role
     */
    public function getRoleInstance(): AbstractUserRole
    {
        return match ($this->role) {
            'admin'   => new AdminRole(),
            'pemilik' => new PemilikRole(),
            'user'    => new UserRole(),
            default   => new UserRole(), // fallback
        };
    }

    /**
     * 🔹 Helper: Mengecek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * 🔹 Helper: Mengecek apakah user memiliki permission tertentu
     * Permission diambil dari instance role melalui method permissions().
     */
    public function hasPermission(string $permission): bool
    {
        $instance = $this->getRoleInstance();

        $perms = $instance->permissions() ?? [];

        return in_array($permission, $perms, true);
    }
}
