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

class ContactController extends Controller
{
    public function formAction(Request $request)
    {

        return $this->render('TLHContactBundle:Contact:form.html.twig', array(
            // 'form' => $form->createView(),
        ));
    }
}