<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @property SocialAccount[] $providers
 * @property string $email
 * @property int $id
 * @property int $email_verified_at
 * @method static Builder|self emailNotVerified()
 * @method static Builder|self byEmail(string $email)
 * @package App\Models\Auth
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use Notifiable;
    use HasFactory;

    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id',
        'name',
        'email_verified_at',
        'updated_at',
        'created_at',
    ];

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    public function scopeEmailNotVerified(Builder $query): Builder
    {
        return $query->whereNull('email_verified_at');
    }
}
