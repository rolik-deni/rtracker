<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\TvNetwork;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Tvnetwork controller.
 *
 */
class TvNetworkController extends Controller
{
  /**
   * Lists all tvNetwork entities.
   *
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $tvNetworks = $em->getRepository('ApiBundle:TvNetwork')->findAll();

    $response = RestController::createResponse($request, $tvNetworks);
    return new JsonResponse($response, 200);
  }

  /**
   * Creates a new tvNetwork entity.
   *
   */
  public function newAction(Request $request)
  {
    $tvNetwork = new TvNetwork();
    $form    = $this->createForm('ApiBundle\Form\TvNetworkType', $tvNetwork);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($tvNetwork);
      $em->flush($tvNetwork);

      $response = RestController::createResponse($request, ['id' => $tvNetwork->getId()]);
      return new JsonResponse($response, 201);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Finds and displays a tvNetwork entity.
   *
   */
  public function showAction(TvNetwork $tvNetwork, int $id)
  {
    $em = $this->getDoctrine()->getManager();

    $tvNetwork = $em->getRepository('ApiBundle:TvNetwork')->find($id);

    if (!$tvNetwork) {
      $response = RestController::createErrorResponse($request, 'TvNetwork not found');
      return new JsonResponse($response, 404);
    }

    $response = RestController::createResponse($request, $tvNetwork);
    return new JsonResponse($response, 200);
  }

  /**
   * Displays a form to edit an existing tvNetwork entity.
   *
   */
  public function editAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $tvNetwork = $em->getRepository('ApiBundle:TvNetwork')->find($id);

    if (!$tvNetwork) {
      $response = RestController::createErrorResponse($request, 'TvNetwork not found');
      return new JsonResponse($response, 404);
    }

    $editForm = $this->createForm('ApiBundle\Form\TvNetworkType', $tvNetwork, ['method' => 'PUT']);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em->flush();

      $response = RestController::createResponse($request, ['id' => $tvNetwork->getId()]);
      return new JsonResponse($response, 200);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Deletes a tvNetwork entity.
   *
   */
  public function deleteAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $tvNetwork = $em->getRepository('ApiBundle:TvNetwork')->find($id);

    if (!$tvNetwork) {
      $response = RestController::createErrorResponse($request, 'TvNetwork not found');
      return new JsonResponse($response, 404);
    }

    $em->remove($tvNetwork);
    $em->flush($tvNetwork);

    $response = RestController::createResponse($request, ['id' => $id]);
    return new JsonResponse($response, 200);
  }
}
