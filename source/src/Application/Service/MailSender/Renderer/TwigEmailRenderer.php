<?php
namespace App\Application\Service\MailSender\Renderer;

final class TwigEmailRenderer implements EmailRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $template
     * @param array $data
     * @return RenderedEmail
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(string $template, array $data): RenderedEmail
    {
        $data = $this->twig->mergeGlobals($data);
        $template = $this->twig->load($template);
        $subject = $template->renderBlock('subject', $data);
        $body = $template->renderBlock('body', $data);

        return new RenderedEmail($subject, $body);
    }
}