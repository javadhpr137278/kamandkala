<?php

namespace App\Services\Messages;

class MessageService
{
    private $message;
    public function __construct(MessageInterface $message)
    {
        $this->message=$message;
    }

    public function send()
    {
        $this->message->sendMessage();
    }
}
