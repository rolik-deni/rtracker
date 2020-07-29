<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\ValidationStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Validationstatus controller.
 *
 */
class ValidationStatusController extends Controller
{
  /**
   * Lists all validationStatus entities.
   *
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $validationStatuses = $em->getRepository('ApiBundle:ValidationStatus')->findAll();

    $response = RestController::createResponse($request, $validationStatuses);
    return new JsonResponse($response, 200);
  }

  /**
   * Creates a new validationStatus entity.
   *
   */
  public function newAction(Request $request)
  {
    $validationStatus = new ValidationStatus();
    $form             = $this->createForm('ApiBundle\Form\ValidationStatusType', $validationStatus);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($validationStatus);
      $em->flush($validationStatus);

      $response = RestController::createResponse($request, ['id' => $validationStatus->getId()]);
      return new JsonResponse($response, 201);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Finds and displays a validationStatus entity.
   *
   */
  public function showAction(Request $request, int $id)
  {
    $em = $this->getDoctrine()->getManager();

    $validationStatus = $em->getRepository('ApiBundle:ValidationStatus')->find($id);

    if (!$validationStatus) {
      $response = RestController::createErrorResponse($request, 'ValidationStatus not found');
      return new JsonResponse($response, 404);
    }

    $response = RestController::createResponse($request, $validationStatus);
    return new JsonResponse($response, 200);
  }

  /**
   * Displays a form to edit an existing validationStatus entity.
   *
   */
  public function editAction(Request $request, int $id)
  {
    $em               = $this->getDoctrine()->getManager();
    $validationStatus = $em->getRepository('ApiBundle:ValidationStatus')->find($id);

    if (!$validationStatus) {
      $response = RestController::createErrorResponse($request, 'ValidationStatus not found');
      return new JsonResponse($response, 404);
    }

    $editForm = $this->createForm('ApiBundle\Form\ValidationStatusType', $validationStatus, ['method' => 'PUT']);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em->flush();

      $response = RestController::createResponse($request, ['id' => $validationStatus->getId()]);
      return new JsonResponse($response, 200);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Deletes a validationStatus entity.
   *
   */
  public function deleteAction(Request $request, int $id)
  {
    $em               = $this->getDoctrine()->getManager();
    $validationStatus = $em->getRepository('ApiBundle:ValidationStatus')->find($id);

    if (!$validationStatus) {
      $response = RestController::createErrorResponse($request, 'ValidationStatus not found');
      return new JsonResponse($response, 404);
    }

    $em->remove($validationStatus);
    $em->flush($validationStatus);

    $response = RestController::createResponse($request, ['id' => $id]);
    return new JsonResponse($response, 200);
  }
}
