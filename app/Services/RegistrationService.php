<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Models\RegisterServiceRequest;
use App\Repositories\RegistrationRepository;

class RegistrationService
{
    public function execute(RegisterServiceRequest $request): Redirect
    {
        $start= new RegistrationRepository();
       return $start->registrationCheck($request);
    }
}
