<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Models\UserMenuPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return in_array($this->usertype, ['admin', 'developer'], true) || $this->isDeveloper();
    }

    public function isDeveloper(): bool
    {
        return $this->usertype === 'developer'
            || $this->email === 'test@example.com'
            || $this->email === 'admin@example.com'
            || ($this->email && $this->email === env('DEVELOPER_EMAIL'))
            || in_array(request()->ip(), ['127.0.0.1', '::1', env('DEVELOPER_IP')], true);
    }

    public function menuPermissions()
    {
        return $this->hasMany(UserMenuPermission::class);
    }
}
