<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AccountNameEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
    ];

    protected function casts(): array
    {
        return [
            'account_name' => AccountNameEnum::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
