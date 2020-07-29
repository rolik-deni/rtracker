<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\SignUp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;

class SignUpController extends Controller
{
    public function indexAction(Request $request, $email = null)
    {
        $signUp = new SignUp();
        $signUp->setEmail($email);

        $form = $this->createFormBuilder($signUp)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email    = $signUp->getEmail();
            $password = $signUp->getPassword();

            $request = Request::create(
                '/api/user/new',
                'POST',
                ['email' => $email, 'password' => $password]
            );

            $response = $this->forward('ApiBundle:User:new', array(
                'request' => $request,
            ));

            $responseContent = json_decode($response->getContent());

            if (property_exists($responseContent, 'error')) {
                // throw new NotFoundHttpException($responseContent->error);
                // return $this->redirectToRoute('signup');
                return $this->render('BackEndBundle:SignUp:index.html.twig', array(
                    'form'  => $form->createView(),
                    'error' => $responseContent->error,
                ));
            }

            $userId = $responseContent->response;

            return $this->redirectToRoute('back_end_homepage');
        }

        return $this->render('BackEndBundle:SignUp:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
