<?php

namespace App\Services\Messages\SMS;

use App\Services\Messages\MessageInterface;

class SmsService implements MessageInterface
{
    public function __construct(
        private string $receiver,
        private string $content,
        private MelipayamakService $melipayamak
    )
    {
    }

    public function sendMessage()
    {
        $this->melipayamak->sendSimpleSMS(
            $this->receiver,
            $this->content
        );
    }
}
