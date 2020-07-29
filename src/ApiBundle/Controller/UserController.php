<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction(Request $request)
    {
        $query = $this->get('doctrine')->getManager()
            ->createQuery('
      SELECT u, s, e
      FROM ApiBundle:User u
        LEFT JOIN u.serial s
        LEFT JOIN u.episode e
      ');

        $result = $query->getResult();

        if (!$result) {
            $response = RestController::createErrorResponse($request, 'Users not found');
            return new JsonResponse($response, 404);
        }

        $response = RestController::createResponse($request, $result);
        return new JsonResponse($response, 200);
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('ApiBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            try {
                $em->flush($user);
            } catch (UniqueConstraintViolationException $e) {
                $response = RestController::createErrorResponse($request, 'Пользователь с таким email уже зарегистрирован');
                return new JsonResponse($response, 422);
            }

            $response = RestController::createResponse($request, ['id' => $user->getId()]);
            return new JsonResponse($response, 201);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($request->query->has('id')) {
            $id = (int) $request->query->get('id');
        } else if ($user != 'anon.') {
            $id = $user->getId();
        } else {
            $id = 0;
        }

        // $id = $request->query->has('id') ? (int) $request->query->get('id') : 0;

        $query = $this->get('doctrine')->getManager()
            ->createQuery('
      SELECT u, s, e
      FROM ApiBundle:User u
        LEFT JOIN u.serial s
        LEFT JOIN u.episode e
      WHERE u.id = :id
      ')->setParameter('id', $id);

        $user = $query->getOneOrNullResult();

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $response = RestController::createResponse($request, $user);
        return new JsonResponse($response, 200);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($request->request->has('id')) {
            $id = (int) $request->request->get('id');
        } else if ($user != 'anon.') {
            $id = $user->getId();
        } else {
            $id = 0;
        }
        // $id = $request->request->has('id') ? (int) $request->request->get('id') : 0;

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($id);

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $oldUser  = clone $user;
        $editForm = $this->createForm('ApiBundle\Form\UserType', $user, ['method' => 'PUT']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if (empty($user->getPassword())) {
                $user->setPassword($oldUser->getPassword());
            }
            try {
                $em->flush($user);
            } catch (UniqueConstraintViolationException $e) {
                $response = RestController::createErrorResponse($request, 'A user with this email already exists');
                return new JsonResponse($response, 422);
            }

            $response = RestController::createResponse($request, ['id' => $user->getId()]);
            return new JsonResponse($response, 200);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    // public function editAction(Request $request)
    // {
    //     $user = $this->get('security.token_storage')->getToken()->getUser();
    //     if ($request->request->has('id')) {
    //         $id = (int) $request->request->get('id');
    //     } else if ($user != 'anon.') {
    //         $id = $user->getId();
    //     } else {
    //         $id = 0;
    //     }
    //     // $id = $request->request->has('id') ? (int) $request->request->get('id') : 0;

    //     $em   = $this->getDoctrine()->getManager();
    //     $user = $em->getRepository('ApiBundle:User')->find($id);

    //     if (!$user) {
    //         $response = RestController::createErrorResponse($request, 'User not found');
    //         return new JsonResponse($response, 404);
    //     }

    //     $userEdit = new User;
    //     $editForm = $this->createForm('ApiBundle\Form\UserType', $userEdit, ['method' => 'PUT']);
    //     $editForm->handleRequest($request);

    //     if ($editForm->isSubmitted() && $editForm->isValid()) {

    //         if (!empty($userEdit->getEmail())) {
    //             $user->setEmail($userEdit->getEmail());
    //         }
    //         if (!empty($userEdit->getPassword())) {
    //             $user->setPassword($userEdit->getPassword());
    //         }
    //         if (!($userEdit->getSerial())->isEmpty()) {
    //             ($user->getSerial())->clear();
    //             foreach ($userEdit->getSerial() as $serial) {
    //                 $user->addSerial($serial);
    //             }
    //         }
    //         if (!($userEdit->getEpisode())->isEmpty()) {
    //             ($user->getEpisode())->clear();
    //             foreach ($userEdit->getEpisode() as $episode) {
    //                 $user->addEpisode($episode);
    //             }
    //         }

    //         try {
    //             $em->flush($user);
    //         } catch (UniqueConstraintViolationException $e) {
    //             $response = RestController::createErrorResponse($request, 'A user with this email already exists');
    //             return new JsonResponse($response, 422);
    //         }

    //         $response = RestController::createResponse($request, ['id' => $user->getId()]);
    //         return new JsonResponse($response, 200);
    //     }

    //     $response = RestController::createErrorResponse($request, 'Not valid data');
    //     return new JsonResponse($response, 422);
    // }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $id = $request->request->has('id') ? (int) $request->request->get('id') : 0;

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($id);

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $em->remove($user);
        $em->flush($user);

        $response = RestController::createResponse($request, ['id' => $id]);
        return new JsonResponse($response, 200);
    }
}
