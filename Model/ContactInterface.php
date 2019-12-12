<?php
/**
 * @package TLH\ContactBundle\Model
 * User: jdevergnies
 * Date: 12/12/2019
 * Time: 16:13
 */

namespace TLH\ContactBundle\Model;

interface ContactInterface
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string
     */
    public function getCreation();
}
