<?php
namespace App\Application\Service\MailSender\Renderer;

interface EmailRendererInterface
{
    public function render(string $template, array $data): RenderedEmail;
}