<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
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
        ];
    }

    /**
     * Get the accounts for the user.
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public static function getTopUsers(): Builder
    {
        return User::query()
            ->select('users.id', 'users.name')
            ->join('accounts', 'accounts.user_id', '=', 'users.id')
            ->join('cards', 'cards.account_id', '=', 'accounts.id')
            ->join('transactions', function ($join) {
                $join->on('transactions.source_card_id', '=', 'cards.id')
                    ->orOn('transactions.destination_card_id', '=', 'cards.id');
            })
            ->groupBy('users.id')
            ->orderByRaw('COUNT(transactions.id) DESC');
    }
}
