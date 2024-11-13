<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\EmailRegistrationDTO;
use App\Models\EmailRegistration;

class EmailRegistrationService
{
    public function create(EmailRegistrationDTO $emailRegistrationDTO)
    {
        $created = EmailRegistration::create([
            'email' => $emailRegistrationDTO->email,
            'company' => $emailRegistrationDTO->company,
            'region' => $emailRegistrationDTO->region,
            'comment' => $emailRegistrationDTO->comment ?? ''
        ]);

        return $created;
    }
}
