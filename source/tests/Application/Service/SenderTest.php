<?php
namespace App\Tests\Application\Service;

use App\Application\Service\MailSender\Renderer\RenderedEmail;
use App\Application\Service\MailSender\Renderer\TwigEmailRenderer;
use App\Application\Service\MailSender\Sender\SwiftMailer;
use App\Application\Service\Sender;
use App\Tests\TestCase;

class SenderTest extends TestCase
{
    public function testSend()
    {
        $recipients = ['di_07@inbox.ru', 'namahtee@gmail.com'];

        $mailer = new SwiftMailer($this->getMockMailer(count($recipients)));

        $renderer = $this->getMockRenderer('template_path', []);

        $sender = new Sender($renderer, $mailer);

        $sendResult = $sender->send('namahtee@gmail.com', $recipients, 'template_path', []);

        $this->assertEquals(count($recipients), $sendResult);
    }

    /**
     * @param string $templatePath
     * @param array $templateData
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getMockRenderer(string $templatePath, array $templateData): \PHPUnit\Framework\MockObject\MockObject
    {
        $renderer = $this->getMockBuilder(TwigEmailRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $renderer
            ->expects($this->once())
            ->method('render')
            ->with($templatePath, $templateData)
            ->willReturn(new RenderedEmail('subject', 'body'));

        return $renderer;
    }

    /**
     * @param int $recipientsCount
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getMockMailer(int $recipientsCount): \PHPUnit\Framework\MockObject\MockObject
    {
        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mailer
            ->expects($this->once())
            ->method('send')
            ->willReturn($recipientsCount);

        return $mailer;
    }
}