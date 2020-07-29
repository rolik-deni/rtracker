<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchController extends Controller
{
    public function indexAction()
    {
        $request = Request::create(
            '/api/genre',
            'GET'
        );
        $response = $this->forward('ApiBundle:Genre:index', array(
            'request' => $request,
        ));
        $responseContent = json_decode($response->getContent());
        if (property_exists($responseContent, 'error')) {
            throw new NotFoundHttpException($responseContent->error);
        }
        $genres = json_decode($response->getContent())->response;

        $request = Request::create(
            '/api/tvnetwork',
            'GET'
        );
        $response = $this->forward('ApiBundle:TvNetwork:index', array(
            'request' => $request,
        ));
        $responseContent = json_decode($response->getContent());
        if (property_exists($responseContent, 'error')) {
            throw new NotFoundHttpException($responseContent->error);
        }
        $tvNetworks = json_decode($response->getContent())->response;

        $request = Request::create(
            '/api/serial/search',
            'GET',
            [
                'fields' => 'yearStart',
                'sort'   => 'serial.id',
            ]
        );
        $response = $this->forward('ApiBundle:Serial:Search', array(
            'request' => $request,
        ));
        $responseContent = json_decode($response->getContent());
        if (property_exists($responseContent, 'error')) {
            throw new NotFoundHttpException($responseContent->error);
        }
        $yearStart = json_decode($response->getContent())->response;

        $yearsStartArray = [];
        foreach ($yearStart as $value) {
            array_push($yearsStartArray, $value->yearStart);
        }
        sort($yearsStartArray);

        return $this->render('BackEndBundle:Search:index.html.twig',
            [
                'genres'     => $genres,
                'tvNetworks' => $tvNetworks,
                'years'      => array_unique($yearsStartArray),
            ]
        );
    }

}
