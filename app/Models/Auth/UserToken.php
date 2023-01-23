<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserToken
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expires_at
 * @property int $created_at
 * @property string $action
 * @method static Builder|self notExpire()
 * @property  User $user
 * @package App\Models\Auth
 */
class UserToken extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    public const ACTION_EMAIL_VERIFICATION = 'email_verification';

    protected $fillable = [
        'expires_at',
        'user_id',
        'token',
        'action'
    ];
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tokens';

    public function scopeNotExpire(Builder $query): Builder
    {
        return $query->where('expires_at', '>', time());
    }
}
