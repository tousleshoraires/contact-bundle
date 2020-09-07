<?php

namespace Tests\TLH\ContactBundle\Entity;

use PHPUnit\Framework\TestCase;
use TLH\ContactBundle\Entity\Contact;

class ContactTest extends TestCase
{
    /**
     * @test
     * @group Entity
     */
    public function specificationsOfContact()
    {
        $email = 'name@domain.tld';
        $message = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        $contact = new Contact();
        $contact->setEmail($email);
        $contact->setMessage($message);

        $this->assertEquals($email, $contact->getEmail());
        $this->assertEquals($message, $contact->getMessage());
    }

    /**
     * @test
     * @group Entity
     */
    public function fluentSetters()
    {
        $contact = new Contact();

        $contact
            ->setEmail('email@domain.tld')
            ->setMessage('my message')
            ->setCreation(new \DateTime("now"));

        $this->assertInstanceOf(Contact::class, $contact);
    }
}
