<?php
namespace App\Application\Service\MailSender\Sender;

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

    //TODO:ответ
    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        $swiftMessage = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($recipients)
            ->setBody($body);

        $this->mailer->send($swiftMessage);
    }
}