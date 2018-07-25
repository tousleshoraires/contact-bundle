<?php

namespace TLH\ContactBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Messager
{
    /**
     * @var RequestStack
     */
    private $requestStack;

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
    public function __construct(EngineInterface $templating, \Swift_Mailer $mailer, RequestStack $requestStack)
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
     * @param $contact
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
     * @param $contact
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
        list($subject, $text, $html) = $this->getEmailContent($renderedTemplate);

        /** @var \Swift_Message $message */
        $message = $this->mailer->createMessage();
        $message
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($text, 'text/plain');

        if (!is_null($html)) {
            $message->addPart($html, 'text/html');
        }

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

    /**
     * @param $renderedTemplate
     * @return array
     */
    protected function getEmailContent($renderedTemplate): array
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $content = explode("<!DOCTYPE html>", $body);

        $text = $body;
        $html = null;
        if (count($content) === 2) {
            $html = '<!DOCTYPE html>' . PHP_EOL . $content[1];
            $text = $content[0];
        }
        return array($subject, $text, $html);
    }
}
