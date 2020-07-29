<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SerialController extends Controller
{
    public function indexAction($id)
    {
        $request = Request::create(
            '/api/serial/get',
            'GET',
            ['id' => $id]
        );

        $response = $this->forward('ApiBundle:Serial:Show', array(
            'request' => $request,
        ));

        $responseContent = json_decode($response->getContent());

        if (property_exists($responseContent, 'error')) {
            throw new NotFoundHttpException($responseContent->error);
        }

        $serial = $responseContent->response;

        if (!empty($serial->episodeNumber)) {
            $request = Request::create(
                '/api/serial/episodes',
                'GET',
                ['id' => $id, 'order' => 'DESC']
            );

            $response = $this->forward('ApiBundle:Serial:Episodes', array(
                'request' => $request,
            ));

            $responseContent = json_decode($response->getContent());

            if (isset($responseContent->error)) {
                throw new NotFoundHttpException($responseContent->error);
            }

            $episodes = $responseContent->response;

            $season = [];
            foreach ($episodes as $episode) {
                $season[] = $episode->seasonNumber;
            }
            $season = array_values(array_unique($season, SORT_NUMERIC));

            foreach ($episodes as $episode) {
                $res                                                                 = new \stdClass;
                $res->id                                                             = $episode->id;
                $res->title                                                          = $episode->title;
                $res->originalTitle                                                  = $episode->originalTitle;
                $res->number                                                         = $episode->number;
                $res->seasonNumber                                                   = $episode->seasonNumber;
                $res->releaseDate                                                    = $episode->releaseDate;
                $episodes['season'][array_search($episode->seasonNumber, $season)][] = $res;
            }

        } else {
            $episodes = null;
        }

        return $this->render('BackEndBundle:Serial:index.html.twig', [
            'serial'  => $serial,
            'episode' => $episodes,
        ]);
    }

}
