<?php
namespace App\Infrastructure\MailSender\Sender\Adapter;

interface MailerInterface
{
    public function send(string $from, array $recipients, string $subject, string $body): void;
}