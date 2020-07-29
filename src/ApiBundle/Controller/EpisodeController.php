<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Episode controller.
 *
 */
class EpisodeController extends Controller
{
    /**
     * Lists all episode entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $episodes = $em->getRepository('ApiBundle:Episode')->findAll();

        $response = RestController::createResponse($request, $episodes);
        return new JsonResponse($response, 200);
    }

    /**
     * Creates a new episode entity.
     *
     */
    public function newAction(Request $request)
    {
        $episode = new Episode();
        $form    = $this->createForm('ApiBundle\Form\EpisodeType', $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush($episode);

            $response = RestController::createResponse($request, ['id' => $episode->getId()]);
            return new JsonResponse($response, 201);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    /**
     * Finds and displays a episode entity.
     *
     */
    public function showAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $episode = $em->getRepository('ApiBundle:Episode')->find($id);

        if (!$episode) {
            $response = RestController::createErrorResponse($request, 'Episode not found');
            return new JsonResponse($response, 404);
        }

        $response = RestController::createResponse($request, $episode);
        return new JsonResponse($response, 200);
    }

    /**
     * Displays a form to edit an existing episode entity.
     *
     */
    public function editAction(Request $request, int $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('ApiBundle:Episode')->find($id);

        if (!$episode) {
            $response = RestController::createErrorResponse($request, 'Episode not found');
            return new JsonResponse($response, 404);
        }

        $editForm = $this->createForm('ApiBundle\Form\EpisodeType', $episode, ['method' => 'PUT']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $response = RestController::createResponse($request, ['id' => $episode->getId()]);
            return new JsonResponse($response, 200);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    /**
     * Deletes a episode entity.
     *
     */
    public function deleteAction(Request $request, int $id)
    {
        $em      = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('ApiBundle:Episode')->find($id);

        if (!$episode) {
            $response = RestController::createErrorResponse($request, 'Episode not found');
            return new JsonResponse($response, 404);
        }

        $em->remove($episode);
        $em->flush($episode);

        $response = RestController::createResponse($request, ['id' => $id]);
        return new JsonResponse($response, 200);
    }
}
