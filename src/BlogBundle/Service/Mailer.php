<?php

namespace BlogBundle\Service;

class Mailer
{

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var string $emailFrom
     */
    protected $emailFrom;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     * @param $emailFrom
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $emailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->emailFrom = $emailFrom;
    }

    /**
     * @param $subject
     * @param $mailTo
     * @param $template
     * @param $params
     */
    public function send($subject, $mailTo, $template, $params)
    {
        $content = $this->twig->render($template, $params);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->emailFrom)
            ->setTo($mailTo)
            ->setContentType('text/html')
            ->setBody($content);

        $this->mailer->send($message);
    }

}