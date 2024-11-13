<?php

declare(strict_types=1);

namespace App\DTO;

class EmailRegistrationDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $company,
        public readonly string $region,
        public readonly ?string $comment,
    ) {}
}
