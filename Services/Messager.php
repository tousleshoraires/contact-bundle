<?php

namespace TLH\ContactBundle\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Messager implements MessagerInterface
{
    private RequestStack $requestStack;
    private Environment $templating;
    private MailerInterface $mailer;

    private array $parameters = [];

    /**
     * Messager constructor.
     */
    public function __construct(Environment $templating, MailerInterface $mailer, RequestStack $requestStack)
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
    public function setParameters(array $parameters)
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
    public function sendConfirmationEmailMessage($contact, $template): void
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
    public function sendInformationEmailMessage($contact, $template): void
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
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail): void
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = (new Email())
            ->subject($subject)
            ->from($fromEmail)
            ->to($toEmail)
            ->html($body);

        $this->mailer->send($message);
    }

    /**
     * @param $contact
     * @param string $template
     * @return string
     */
    private function renderTemplate($contact, $template): string
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
