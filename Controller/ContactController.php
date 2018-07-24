<?php

/*
 * This file is part of the TLHContactBundle package.
 *
 * (c) TLH <http://github.com/tousleshoraires>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TLH\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use TLH\ContactBundle\Entity\Contact;
use TLH\ContactBundle\Form\ContactType;

class ContactController extends Controller
{
    public function formAction()
    {
        $contactClass = $this->getParameter('tlh_contact.class');
        $contact = new $contactClass;

        $form   = $this->createContactForm($contact);

        return $this->render('TLHContactBundle:Contact:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function formCreateAction(Request $request)
    {
        $contactClass = $this->getParameter('tlh_contact.class');
        $contact = new $contactClass;

    	$form   = $this->createContactForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();
            $session->getFlashBag()->add('notice', $this->get('translator')->trans('contact.confirmed', [], 'TLHContactBundle'));

            if( $this->getParameter('tlh_contact.confirmation.enabled') ) {
                $this->sendConfirmationEmailMessage($contact, $request);
            }

            if( $this->getParameter('tlh_contact.information.enabled') ) {
                $this->sendInformationEmailMessage($contact, $request);
            }

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('tlh_contact_form');
        }

        return $this->render('TLHContactBundle:Contact:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createContactForm($entity)
    {
        $contactClass = $this->getParameter('tlh_contact.class');

        $form = $this->createForm($this->getParameter('tlh_contact.form'), $entity, array(
            'action' => $this->generateUrl('tlh_contact_form_create'),
            'method' => 'POST',
            'data_class' => $contactClass
        ));

        $form->add('submit', SubmitType::class, array('label' => 'form.submit', 'translation_domain' => 'TLHContactBundle'));

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function sendConfirmationEmailMessage($contact, Request $request)
    {
        $url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $rendered = $this->get('templating')->render($this->getParameter('tlh_contact.confirmation.template'), array(
            'website' =>  $url,
            'contact' => $contact
        ));
        $this->sendEmailMessage($rendered, $this->getParameter('tlh_contact.confirmation.from_email.address'), $this->getParameter('tlh_contact.recipient_address'));
    }

    /**
     * {@inheritdoc}
     */
    public function sendInformationEmailMessage($contact, Request $request)
    {
        $url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $rendered = $this->get('templating')->render($this->getParameter('tlh_contact.information.template'), array(
            'website' =>  $url,
            'contact' => $contact
        ));
        $this->sendEmailMessage($rendered, $this->getParameter('tlh_contact.information.from_email.address'), $this->getParameter('tlh_contact.recipient_address'));
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

        $this->get('mailer')->send($message);
    }
}
