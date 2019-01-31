<?php
namespace App\Application\Service;

interface SenderInterface
{
    public function send(string $from, array $recipients, string $template, array $data): void;
}