<?php

namespace TLH\ContactBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TLH\ContactBundle\Entity\Contact;

class ContactTest extends TestCase
{
    /**
     * @test
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
}
