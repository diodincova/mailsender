<?php
namespace App\Infrastructure\Controller\Rest;

use App\Application\Service\MailSender;
//use App\Application\Service\MessageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class MessageController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/send/email")
     * @param Request $request
     * @return string
     */
    public function sendMail(Request $request)
    {
        var_dump($request->get('check'));

        $transport = new \Swift_SpoolTransport(new MailSender(
            (new \Enqueue\Fs\FsConnectionFactory('file://'.__DIR__.'/queue'))->createContext()
        ));
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom('namahtee@gmail.com')
            ->setTo('namahtee@gmail.com')
            ->setBody('Here is the message itself. Sent at: '.date('Y-m-d H:i:s'))
        ;

        $result = $mailer->send($message);

        /** @var \Swift_QueueSpool $spool */
        $spool = $transport->getSpool();
        $spool->setTimeLimit(3);
        $realTransport = (new \Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
            ->setUsername('di_07@inbox.ru')
            ->setPassword('matisyahu720')
        ;
        $spool->flushQueue($realTransport);

        return new Response('check');
    }

//    /**
//     * Creates an Article resource
//     * @Rest\Post("/articles")
//     * @ParamConverter("articleDTO", converter="fos_rest.request_body")
//     * @param ArticleDTO $articleDTO
//     * @return View
//     */
//    public function postArticle(ArticleDTO $articleDTO): View
//    {
//        $article = $this->articleService->addArticle($articleDTO);
//        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
//        return View::create($article, Response::HTTP_CREATED);
//    }
}