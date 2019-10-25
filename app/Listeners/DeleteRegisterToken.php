<?php

namespace App\Listeners;

use App\Repositories\RegisterToken;
use Illuminate\Auth\Events\Registered;

class DeleteRegisterToken
{
    public function handle(Registered $event)
    {
        RegisterToken::getInstance()->deleteByEmail($event->user->getEmail());
    }
}
