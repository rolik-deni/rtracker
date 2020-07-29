<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {

        $authUtils = $this->get('security.authentication_utils');

        $error     = $authUtils->getLastAuthenticationError();
        $lastEmail = $authUtils->getLastUsername();

        return $this->render('BackEndBundle:Login:index.html.twig', array(
            'lastEmail' => $lastEmail,
            'error'     => $error,
        ));
    }

}
