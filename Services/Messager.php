<?php

namespace TLH\ContactBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Messager
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Messager constructor.
     */
    public function __construct(EngineInterface $templating, \Swift_Mailer $mailer, Request $request)
    {
        $this->templating = $templating;
        $this->request = $request;
        $this->mailer = $mailer;
    }

    /**
     * @param array $parameters
     *
     * @return Messager
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param string $parameter
     *
     * @return mixed
     */
    public function getParameter($parameter)
    {
        $values = explode(".", $parameter);

        $parameter = $this->parameters;
        while ($key = array_shift($values)) {
            if (!isset($parameter[$key])) {
                unset($parameter);
                break;
            }
            $parameter = $parameter[$key];
        }
        return $parameter;
    }

    /**
     * @param $contact
     */
    public function sendConfirmationEmailMessage($contact)
    {
        $this->sendEmailMessage(
            $this->renderTemplate($contact, 'confirmation.template'),
            $this->getParameter('confirmation.from_email.address'),
            $this->getParameter('recipient_address')
        );
    }

    /**
     * @param $contact
     */
    public function sendInformationEmailMessage($contact)
    {
        $this->sendEmailMessage(
            $this->renderTemplate($contact, 'information.template'),
            $this->getParameter('information.from_email.address'),
            $this->getParameter('recipient_address')
        );
    }

    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
                                 ->setSubject($subject)
                                 ->setFrom($fromEmail)
                                 ->setTo($toEmail)
                                 ->setBody($body);

        $this->mailer->send($message);
    }

    /**
     * @param $contact
     * @param $template
     * @return string
     */
    private function renderTemplate($contact, $template)
    {
        $url      = $this->request->getScheme() . '://' . $this->request->getHttpHost() . $this->request->getBasePath();
        $rendered = $this->templating->render(
            $this->getParameter($template),
            array(
                'website' => $url,
                'contact' => $contact
            )
        );

        return $rendered;
    }
}
