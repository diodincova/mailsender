<?php

namespace App\Infrastructure\Controller\Rest;

use App\Application\Service\SenderInterface;
use App\Presentation\Api\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class MessageController extends AbstractFOSRestController
{
    /** @var SenderInterface */
    private $sender;

    /** @var ResponseFactory */
    private $responseFactory;

    /** @var string */
    private $from;

    public function __construct(SenderInterface $sender, ResponseFactory $responseFactory)
    {
        $this->sender = $sender;
        $this->from = 'namahtee@gmail.com';
        $this->responseFactory = $responseFactory;
    }

    /**
     * @Rest\Post("/email/send")
     *
     * @param Request $request
     * @return \App\Presentation\Api\Response
     * @throws \Exception
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

        $email = [
            'recipients' => $recipients,
            'theme' => $theme,
        ];

        return $this->responseFactory->createResponse($email);
    }
}