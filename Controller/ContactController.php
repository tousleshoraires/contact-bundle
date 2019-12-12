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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\Translation\TranslatorInterface;
use TLH\ContactBundle\Model\ContactInterface;
use TLH\ContactBundle\Services\Messager;

class ContactController extends AbstractController
{
    /** @var Messager $messager */
    protected $messager;
    
    /** @var TranslatorInterface $translator */
    protected $translator;

    /**
     * ContactController constructor.
     * @param Messager $messager
     * @param TranslatorInterface $translator
     */
    public function __construct(Messager $messager, TranslatorInterface $translator)
    {
        $this->messager = $messager;
        $this->translator = $translator;
    }

    /**
     * The Route is defined into the routing.xml file.
     */
    public function formAction()
    {
        $contactClass = $this->getParameter('tlh_contact.class');
        $contact = new $contactClass;

        $form   = $this->createContactForm($contact);

        return $this->render('@TLHContact/Contact/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * The Route is defined into the routing.xml file.
     */
    public function formCreateAction(Request $request)
    {
        $contactClass = $this->getParameter('tlh_contact.class');
        $contact = new $contactClass;

    	$form   = $this->createContactForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
            $session->getFlashBag()->add('notice', $this->translator->trans('contact.confirmed', [], 'TLHContactBundle'));

            if ($this->getParameter('tlh_contact.confirmation.enabled')) {
                $this->messager->sendConfirmationEmailMessage(
                    $contact,
                    $this->getParameter('tlh_contact.confirmation.template')
                );
            }

            if ($this->getParameter('tlh_contact.information.enabled')) {
                $this->messager->sendInformationEmailMessage(
                    $contact,
                    $this->getParameter('tlh_contact.information.template')
                );
            }

            if (!$contact instanceof Contact) {
                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
            }

            return $this->redirectToRoute('tlh_contact_form');
        }

        return $this->render('@TLHContact/Contact/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a contact entity.
     *
     * @param ContactInterface $entity The entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    protected function createContactForm(ContactInterface $entity)
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
}
