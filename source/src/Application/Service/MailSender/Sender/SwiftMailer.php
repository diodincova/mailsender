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

    /**
     * @param string $from
     * @param array $recipients
     * @param string $subject
     * @param string $body
     * @return int
     */
    public function send(string $from, array $recipients, string $subject, string $body): int
    {
        $swiftMessage = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($recipients)
            ->setBody($body);

        return $this->mailer->send($swiftMessage);
    }
}