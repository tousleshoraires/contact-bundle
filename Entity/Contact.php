<?php

namespace TLH\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TLH\ContactBundle\Model\Contact as ModelContact;

/**
 * TLH\ContactBundle\Entity\Contact
 *
 * @deprecated Use TLH\ContactBundle\Model\Contact instead
 * @ORM\Table(name="contact")
 */
class Contact extends ModelContact
{
    public function __construct()
    {
        parent::__construct();
        $this->creation = new \DateTime("now");
    }
}
