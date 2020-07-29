<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResetController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackEndBundle:Reset:index.html.twig', array(
            // ...
        ));
    }

}
