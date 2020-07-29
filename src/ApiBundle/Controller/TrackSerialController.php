<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\User;
use ApiBundle\Service\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class TrackSerialController extends Controller
{
    public function indexAction(Request $request, Helper $helper)
    {
        $userId = $helper->getUserId($request, $this->getUser());
        $serialId = $request->query->has('serial') ? $request->query->get('serial') : null;

        $em = $this->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('s.id')
            ->from('ApiBundle:Serial', 's')
            ->join('s.user', 'u')
            ->where($qb->expr()->eq('u.id', ':userId'))
            ->setParameter('userId', $userId);

        if ($serialId != null) {
            $qb->andWhere($qb->expr()->eq('s.id', ':serialId'))
                ->setParameter('serialId', $serialId);
        }

        $result = $qb->getQuery()->getResult();

        if (!$result) {
            $response = RestController::createErrorResponse($request, 'Non track serial');
            return new JsonResponse($response, 404);
        }

        $resultArr = [];
        foreach ($result as $serialId) {
            $resultArr[] = $serialId['id'];
        }

        $response = RestController::createResponse($request, $resultArr);
        return new JsonResponse($response, 200);
    }

    public function clearAction(Request $request, Helper $helper)
    {
        $userId = $helper->getUserId($request, $this->getUser());

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($userId);

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $user->clearSerial();
        $em->flush($user);

        $response = RestController::createResponse($request, ['id' => $userId]);
        return new JsonResponse($response, 200);
    }

    public function addAction(Request $request, Helper $helper)
    {
        $userId = $helper->getUserId($request, $this->getUser());

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($userId);

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $userEdit = new User;
        $editForm = $this->createForm('ApiBundle\Form\UserType', $userEdit, ['method' => 'PUT']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!empty($userEdit->getSerial())) {
                foreach ($userEdit->getSerial() as $serial) {
                    $user->addSerial($serial);
                }
            }
            try {
                $em->flush($user);
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {}

            $response = RestController::createResponse($request, ['id' => $user->getId()]);
            return new JsonResponse($response, 200);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    public function deleteAction(Request $request, Helper $helper)
    {
        $userId = $helper->getUserId($request, $this->getUser());

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($userId);

        if (!$user) {
            $response = RestController::createErrorResponse($request, 'User not found');
            return new JsonResponse($response, 404);
        }

        $userEdit = new User;
        $editForm = $this->createForm('ApiBundle\Form\UserType', $userEdit, ['method' => 'DELETE']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!empty($userEdit->getSerial())) {
                $serial = $userEdit->getSerial()[0];
                $user->removeSerial($serial);
            }
            $em->flush();

            $response = RestController::createResponse($request, ['id' => $user->getId()]);
            return new JsonResponse($response, 200);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }
}
