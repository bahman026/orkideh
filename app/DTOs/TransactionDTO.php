<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\Carbon;

readonly class TransactionDTO
{
    public function __construct(
        public int $source_card_id,
        public int $destination_card_id,
        public int $amount,
        public string | null | Carbon $created_at = null,
        public string | null | Carbon $updated_at = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['source_card_id'],
            $data['destination_card_id'],
            $data['amount'],
            $data['created_at'] ?? null,
            $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
