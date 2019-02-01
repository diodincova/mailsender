<?php

namespace App\Application\Service;

use App\Application\Service\MailSender\Renderer\EmailRendererInterface;
use App\Application\Service\MailSender\Sender\MailerInterface;

final class Sender implements SenderInterface
{
    /**
     * @var EmailRendererInterface
     */
    private $emailRenderer;

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(EmailRendererInterface $emailRenderer, MailerInterface $mailer)
    {
        $this->emailRenderer = $emailRenderer;
        $this->mailer = $mailer;
    }

    public function send(string $from, array $recipients, string $template, array $data): void
    {
        $renderedEmail = $this->emailRenderer->render($template, $data);

        $this->mailer->send($from, $recipients, $renderedEmail->subject(), $renderedEmail->body());
    }
}