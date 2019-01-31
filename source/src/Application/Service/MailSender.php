<?php

namespace App\Application\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class MailSender
{
    /** @var \Swift_Mailer */
    private $mailer;

    private $templating;

    /** @var string */
    private $sender;

    /** @var string */
    private $subject;

    public function __construct(ContainerInterface $container, \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->templating = $container->get('templating');
        $this->sender = 'namahtee@gmail.com';
        $this->subject = 'subject';
    }

    /**
     * @param $addresses
     * @param string $theme
     * @return int
     */
    public function send($addresses, string $theme)
    {
        $message = (new \Swift_Message($this->subject))
            ->setFrom($this->sender)
            ->setTo($addresses)
            ->setBody(
                $this->templating->render(
                    'emails/' . $theme . '.html.twig'
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}