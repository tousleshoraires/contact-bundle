<?php
/**
 * @package TLH\ContactBundle\Services
 * User: jdevergnies
 * Date: 07/09/2020
 * Time: 13:32
 */

namespace TLH\ContactBundle\Services;

interface MessagerInterface
{
    /**
     * @param $contact
     * @param $template
     * @return void
     */
    public function sendConfirmationEmailMessage($contact, $template);

    /**
     * @param $contact
     * @param $template
     * @return void
     */
    public function sendInformationEmailMessage($contact, $template);
}
