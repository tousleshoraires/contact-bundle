<?php

namespace TLH\ContactBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Messager implements MessagerInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Environment
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
    public function __construct(Environment $templating, \Swift_Mailer $mailer, RequestStack $requestStack)
    {
        $this->templating = $templating;
        $this->requestStack = $requestStack;
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
     * @return mixed|null
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
        return (isset($parameter)) ? $parameter : null;
    }

    /**
     * @inheritDoc
     */
    public function sendConfirmationEmailMessage($contact, $template)
    {
        $this->sendEmailMessage(
            $this->renderTemplate($contact, $template),
            $this->getParameter('confirmation.from_email.address'),
            $this->getParameter('recipient_address')
        );
    }

    /**
     * @inheritDoc
     */
    public function sendInformationEmailMessage($contact, $template)
    {
        $this->sendEmailMessage(
            $this->renderTemplate($contact, $template),
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

        $message = $this->mailer->createMessage();
        $message
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $this->mailer->send($message);
    }

    /**
     * @param $contact
     * @param string $template
     * @return string
     */
    private function renderTemplate($contact, $template)
    {
        $request = $this->requestStack->getCurrentRequest();
        $url      = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $rendered = $this->templating->render(
            $template,
            array(
                'website' => $url,
                'contact' => $contact
            )
        );

        return $rendered;
    }
}
