<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Genre controller.
 *
 */
class GenreController extends Controller
{
  /**
   * Lists all genre entities.
   *
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $genres = $em->getRepository('ApiBundle:Genre')->findAll();

    $response = RestController::createResponse($request, $genres);
    return new JsonResponse($response, 200);
  }

  /**
   * Creates a new genre entity.
   *
   */
  public function newAction(Request $request)
  {
    $genre = new Genre();
    $form    = $this->createForm('ApiBundle\Form\GenreType', $genre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($genre);
      $em->flush($genre);

      $response = RestController::createResponse($request, ['id' => $genre->getId()]);
      return new JsonResponse($response, 201);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Finds and displays a genre entity.
   *
   */
  public function showAction(Request $request, int $id)
  {
    $em = $this->getDoctrine()->getManager();

    $genre = $em->getRepository('ApiBundle:Genre')->find($id);

    if (!$genre) {
      $response = RestController::createErrorResponse($request, 'Genre not found');
      return new JsonResponse($response, 404);
    }

    $response = RestController::createResponse($request, $genre);
    return new JsonResponse($response, 200);
  }

  /**
   * Displays a form to edit an existing genre entity.
   *
   */
  public function editAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $genre = $em->getRepository('ApiBundle:Genre')->find($id);

    if (!$genre) {
      $response = RestController::createErrorResponse($request, 'Genre not found');
      return new JsonResponse($response, 404);
    }

    $editForm = $this->createForm('ApiBundle\Form\GenreType', $genre, ['method' => 'PUT']);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em->flush();

      $response = RestController::createResponse($request, ['id' => $genre->getId()]);
      return new JsonResponse($response, 200);
    }

    $response = RestController::createErrorResponse($request, 'Not valid data');
    return new JsonResponse($response, 422);
  }

  /**
   * Deletes a genre entity.
   *
   */
  public function deleteAction(Request $request, int $id)
  {
    $em      = $this->getDoctrine()->getManager();
    $genre = $em->getRepository('ApiBundle:Genre')->find($id);

    if (!$genre) {
      $response = RestController::createErrorResponse($request, 'Genre not found');
      return new JsonResponse($response, 404);
    }

    $em->remove($genre);
    $em->flush($genre);

    $response = RestController::createResponse($request, ['id' => $id]);
    return new JsonResponse($response, 200);
  }
}
