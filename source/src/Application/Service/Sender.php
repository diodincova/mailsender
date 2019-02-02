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

    /**
     * @param string $from
     * @param array $recipients
     * @param string $template
     * @param array $data
     * @return bool|int
     */
    public function send(string $from, array $recipients, string $template, array $data)
    {
        try {
            $renderedEmail = $this->emailRenderer->render($template, $data);
        } catch (\Throwable $e) {
            return false;
        }

        return $this->mailer->send($from, $recipients, $renderedEmail->subject(), $renderedEmail->body());
    }
}