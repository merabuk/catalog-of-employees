<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Position;
use App\Models\Role;
use App\Models\ImageModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'position_id',
        'salary',
        'head_id',
        'date_of_employment',
        'admin_created_id',
        'admin_updated_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function image()
    {
        return $this->hasOne(ImageModel::class);
    }

    public function head()
    {
        return $this->belongsTo(User::class);
    }

    public static function getUsersByRoleSlug($role)
    {
        $findedRole = Role::where('slug', $role)->first();
        return $findedRole->users;
    }

    public function scopeEmployees($query)
    {
        $employeeRoleId = Role::getRoleBySlug('employee')->id;
        return $query->where('role_id', $employeeRoleId);
    }
}
