<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Country controller.
 *
 */
class CountryController extends Controller
{
  /**
   * Lists all country entities.
   *
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $countries = $em->getRepository('ApiBundle:Country')->findAll();

    $response = RestController::createResponse($request, $countries);
    return new JsonResponse($response, 200);
  }

  /**
   * Creates a new country entity.
   *
   */
  public function newAction(Request $request)
  {
    $country = new Country();
    $form    = $this->createForm('ApiBundle\Form\CountryType', $country);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($country);
      $em->flush($country);

      $response = RestController::createResponse($request, ['id' => $country->getId()]);
      return new JsonResponse($response, 201);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Finds and displays a country entity.
   *
   */
  public function showAction(Request $request, int $id)
  {
    $em = $this->getDoctrine()->getManager();

    $country = $em->getRepository('ApiBundle:Country')->find($id);

    if (!$country) {
      $response = RestController::createErrorResponse($request, 'Country not found');
      return new JsonResponse($response, 404);
    }

    $response = RestController::createResponse($request, $country);
    return new JsonResponse($response, 200);
  }

  /**
   * Displays a form to edit an existing country entity.
   *
   */
  public function editAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $country = $em->getRepository('ApiBundle:Country')->find($id);

    if (!$country) {
      $response = RestController::createErrorResponse($request, 'Country not found');
      return new JsonResponse($response, 404);
    }

    $editForm = $this->createForm('ApiBundle\Form\CountryType', $country, ['method' => 'PUT']);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em->flush();

      $response = RestController::createResponse($request, ['id' => $country->getId()]);
      return new JsonResponse($response, 200);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Deletes a country entity.
   *
   */
  public function deleteAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $country = $em->getRepository('ApiBundle:Country')->find($id);

    if (!$country) {
      $response = RestController::createErrorResponse($request, 'Country not found');
      return new JsonResponse($response, 404);
    }

    $em->remove($country);
    $em->flush($country);

    $response = RestController::createResponse($request, ['id' => $id]);
    return new JsonResponse($response, 200);
  }
}
