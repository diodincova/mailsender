<?php
namespace App\Infrastructure\MailSender\Renderer\Adapter;

use App\Infrastructure\MailSender\Renderer\RenderedEmail;

interface EmailRendererInterface
{
    public function render(string $template, array $data): RenderedEmail;
}