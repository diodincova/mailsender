<?php
namespace App\Application\Service\MailSender\Renderer\Adapter;

use App\Application\Service\MailSender\Renderer\RenderedEmail;

interface EmailRendererInterface
{
    public function render(string $template, array $data): RenderedEmail;
}