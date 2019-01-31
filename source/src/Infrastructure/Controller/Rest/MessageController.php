<?php
namespace App\Infrastructure\Controller\Rest;

use App\Application\Service\MailSender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class MessageController extends AbstractFOSRestController
{
    /** @var MailSender */
    private $mailer;

    public function __construct(MailSender $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Rest\Post("/send/email")
     *
     * @param Request $request
     * @return Response
     */
    public function sendMail(Request $request)
    {
        $this->mailer->send($request['users'], $request['theme']);

        return new Response('check');
    }
}