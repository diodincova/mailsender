<?php

namespace App\Controller\Rest;

use App\Application\Service\Rest\Response;
use App\Application\Service\SenderInterface;
use App\Application\Service\Rest\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageController extends AbstractFOSRestController
{
    /** @var SenderInterface */
    private $sender;

    /** @var ResponseFactory */
    private $responseFactory;

    /** @var ValidatorInterface */
    private $validator;

    /** @var string */
    private $from;

    /** @var string */
    private $emailPath;

    public function __construct(
        SenderInterface $sender,
        ResponseFactory $responseFactory,
        ValidatorInterface $validator
    )
    {
        $this->sender = $sender;
        $this->responseFactory = $responseFactory;
        $this->validator = $validator;
        $this->from = 'namahtee@gmail.com';
        $this->emailPath = 'emails/';
    }

    /**
     * @Rest\Post("/email/send")
     *
     * @param Request $request
     * @return \App\Application\Service\Rest\Response
     * @throws \Exception
     */
    public function sendMail(Request $request)
    {
        if (NULL === $request->get('theme')) {
            $errors[] = 'Choose \'theme\' for email: \'welcome\', \'registration\'';
            return $this->responseFactory->createResponse([], Response::HTTP_BAD_REQUEST, $errors);
        }

        if (NULL === $request->get('users')) {
            $errors[] = 'Specify the recipients of the letter';
            return $this->responseFactory->createResponse([], Response::HTTP_BAD_REQUEST, $errors);
        }

        $emails = is_array($request->get('users')) ? $request->get('users') : [$request->get('users')];
        $theme = (string)$request->get('theme');

        $recipientInfo = $this->createRecipientsList($emails);

        if (0 === count($recipientInfo['recipients'])) {
            return $this->responseFactory->createResponse([], Response::HTTP_BAD_REQUEST, $recipientInfo['errors']);
        }

        if (!$this->send($this->from, $recipientInfo['recipients'], $theme)) {
            $errors[] = 'Something goes wrong. Check that theme \'' . $theme . '\' really exist.';
            return $this->responseFactory->createResponse([], Response::HTTP_BAD_REQUEST, $errors);
        }

        $data = [
            'theme' => $theme,
            'recipients' => $recipientInfo['recipients'],
        ];

        return $this->responseFactory->createResponse($data, Response::HTTP_OK, $recipientInfo['errors']);
    }

    /**
     * @param $from
     * @param $recipients
     * @param $theme
     * @return bool
     */
    private function send($from, $recipients, $theme): bool
    {
        return $this->sender->send(
            $from,
            $recipients,
            $this->emailPath . $theme . '.html.twig',
            ['subject' => $theme]
        );
    }

    /**
     * @param array $emails
     * @return array
     */
    private function createRecipientsList(array $emails): array
    {
        $recipients = [];
        $errors = [];

        foreach ($emails as $email) {
            $emailConstraint = new EmailConstraint();
            $emailConstraint->message = 'Invalid email address: ' . $email;

            $emailErrors = $this->validator->validate($email, $emailConstraint);

            if (0 == strlen($email)) {
                $errors[] = 'You have entered an empty email';
            } elseif (0 === count($emailErrors)) {
                $recipients[] = $email;
            } else {
                $errors[] = $emailErrors[0]->getMessage();
            }
        }

        return [
            'recipients' => $recipients,
            'errors' => $errors
        ];
    }
}