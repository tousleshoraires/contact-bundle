<?php

namespace Tests\TLH\ContactBundle\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use TLH\ContactBundle\Form\ContactType;
use TLH\ContactBundle\Entity\Contact;

class ContactTypeTest extends TypeTestCase
{
    /**
     * @test
     */
    public function formIsSubmitedSuccessfully()
    {
        $contact = new Contact();

        $form = $this->factory->create(ContactType::class, $contact);

        $formData = array(
            'email' => 'bar@domain.tld',
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        );
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($contact, $form->getData());
        $this->assertSame('bar@domain.tld', $contact->getEmail());
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return array_merge(parent::getTypes(), array(
            new ContactType('TLH\ContactBundle\Entity\Contact'),
        ));
    }
}
