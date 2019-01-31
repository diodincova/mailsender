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

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
        $this->from = 'namahtee@gmail.com';
    }

    /**
     * @Rest\Post("/send/email")
     *
     * @param Request $request
     * @return Response
     */
    public function sendMail(Request $request)
    {
        $recipients = is_array($request->get('users')) ? $request->get('users') : [$request->get('users')];
        $theme = (string)$request->get('theme');

        $this->sender->send(
            $this->from,
            $recipients,
            'emails/' . $theme . '.html.twig',
            ['subject' => $theme]
        );

        return new Response('check');
    }
}