<?php

namespace App\Infrastructure\Controller\Rest;

use App\Application\Service\SenderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class MessageController extends AbstractFOSRestController
{
    /** @var SenderInterface */
    private $sender;

    /** @var string */
    private $from;

    /** @var string */
    private $subject;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
        $this->from = 'namahtee@gmail.com';
        $this->subject = 'backend test case';
    }

    /**
     * @Rest\Post("/send/email")
     *
     * @param Request $request
     * @return Response
     */
    public function sendMail(Request $request)
    {
        $recipients = is_array($request['users']) ? $request['users'] : [$request['users']];

        $this->sender->send(
            $this->from,
            $recipients,
            'emails/' . $request['theme'] . '.html.twig',
            ['subject' => $this->subject]
        );

        return new Response('check');
    }
}