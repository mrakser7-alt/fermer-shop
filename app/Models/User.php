<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// === БЛОК: Заполняемые поля ===
// Перечисляем поля, которые можно заполнять через форму (защита от mass-assignment)
#[Fillable(['name', 'email', 'password', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    // === БЛОК: Доступ к Filament-панели ===
    // Только пользователи с is_admin = true попадают в /admin
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    // === БЛОК: Связи ===
    // У пользователя может быть много заказов
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // === БЛОК: Преобразование типов ===
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
}
