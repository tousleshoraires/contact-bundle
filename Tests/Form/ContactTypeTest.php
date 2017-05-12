<?php

namespace TLH\ContactBundle\Tests\Form;

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

        $form = $this->factory->create(ContactType::class);

        $formData = array(
            'email' => 'bar@domain.tld',
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        );
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($contact, $form->getData());
        $this->assertSame('bar@domain.tld', $contact->getEmail());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
