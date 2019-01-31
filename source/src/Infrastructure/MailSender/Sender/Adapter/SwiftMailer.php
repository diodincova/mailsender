<?php
namespace App\Infrastructure\MailSender\Sender\Adapter;

final class SwiftMailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        $swiftMessage = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($recipients)
            ->setBody($body);

        $this->mailer->send($swiftMessage);
    }
}