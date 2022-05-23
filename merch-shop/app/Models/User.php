<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function createFromRequest(mixed $data)
    {
        $user = new self();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->app_registered_at = Carbon::now();
        $user->app_logged_in_at = Carbon::now();
        $user->save();
        return $user;
    }

    public function updateFromRequest($data) : self
    {
        $this->password = Hash::make($data['password']);
        $this->app_registered_at = Carbon::now();
        $this->app_logged_in_at = Carbon::now();
        $this->save();
        return $this;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vkontakte_id',
        'vkontakte_logged_in_at',
        'vkontakte_registered_at',
        'github_id',
        'github_logged_in_at',
        'github_registered_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'github_id',
        'vkontakte_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'app_logged_in_at' => 'datetime',
        'app_registered_at' => 'datetime',
        'github_logged_in_at' => 'datetime',
        'github_registered_at' => 'datetime',
        'vkontakte_logged_in_at' => 'datetime',
        'vkontakte_registered_at' => 'datetime',
    ];


}
