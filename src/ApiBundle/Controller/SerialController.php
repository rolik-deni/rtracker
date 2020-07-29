<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Serial;
use ApiBundle\Entity\ValidationStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Serial controller.
 *
 */
class SerialController extends Controller
{
    /**
     * Lists all serial entities.
     *
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getManager()->createQuery('
            SELECT s, g, c, t, v
            FROM ApiBundle:Serial s
                LEFT JOIN s.genre g
                LEFT JOIN s.country c
                LEFT JOIN s.tvNetwork t
                LEFT JOIN s.validationStatus v
        ');

        $result = $query->getResult();

        if (!$result) {
            $response = RestController::createErrorResponse($request, 'Serials not found');
            return new JsonResponse($response, 404);
        }

        $serials = $result;
        foreach ($serials as $serial) {
            $serial->setOutputFields(['*']);
        }
        $response = RestController::createResponse($request, $serials);
        return new JsonResponse($response, 200);
    }

    /**
     * Creates a new serial entity.
     *
     */
    public function newAction(Request $request)
    {
        $serial = new Serial();
        $form   = $this->createForm('ApiBundle\Form\SerialType', $serial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // По-умолчанию статус сериала 'не проверен' (id=2)
            if (is_null($serial->getValidationStatus())) {
                $validationStatus = $em->getRepository(ValidationStatus::class)->find(2);
                $serial->setValidationStatus($validationStatus);
            }

            $em->persist($serial);
            $em->flush($serial);

            $response = RestController::createResponse($request, ['id' => $serial->getId()]);
            return new JsonResponse($response, 201);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    /**
     * Finds and displays a serials entity.
     *
     */
    public function showAction(Request $request)
    {
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('s, g, c, t, v')
            ->from('ApiBundle:Serial', 's')
            ->leftJoin('s.genre', 'g')
            ->leftJoin('s.country', 'c')
            ->leftJoin('s.tvNetwork', 't')
            ->leftJoin('s.validationStatus', 'v')
            ->where($qb->expr()->in('s.id', ':serialsId'));

        $id = $request->query->has('id') ? (int) $request->query->get('id') : 0;

        $qb->setParameter('serialsId', $id);

        $result = $qb->getQuery()->getResult();

        if (!$result) {
            $response = RestController::createErrorResponse($request, 'Serial not found');
            return new JsonResponse($response, 404);
        }

        $serial = $result[0];
        $serial->setOutputFields(['*']);
        $response = RestController::createResponse($request, $serial);

        return new JsonResponse($response, 200);
    }

    // TODO: Добавить возможность обновлять конкретные поля, а не все сразу как сейчас
    /**
     * Displays a form to edit an existing serial entity.
     *
     */
    public function editAction(Request $request)
    {
        $id = $request->request->has('id') ? (int) $request->request->get('id') : 0;

        $em     = $this->getDoctrine()->getManager();
        $serial = $em->getRepository('ApiBundle:Serial')->find($id);

        if (!$serial) {
            $response = RestController::createErrorResponse($request, 'Serial not found');
            return new JsonResponse($response, 404);
        }

        $editForm = $this
            ->createForm('ApiBundle\Form\SerialType', $serial, ['method' => 'PUT'])
            ->add('id');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $response = RestController::createResponse($request, ['id' => $serial->getId()]);
            return new JsonResponse($response, 200);
        }

        $response = RestController::createErrorResponse($request, 'Not valid data');
        return new JsonResponse($response, 422);
    }

    /**
     * Deletes a serial entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $id = $request->request->has('id') ? (int) $request->request->get('id') : 0;

        $em     = $this->getDoctrine()->getManager();
        $serial = $em->getRepository('ApiBundle:Serial')->find($id);

        if (!$serial) {
            $response = RestController::createErrorResponse($request, 'Serial not found');
            return new JsonResponse($response, 404);
        }

        $em->remove($serial);
        $em->flush($serial);

        $response = RestController::createResponse($request, ['id' => $id]);
        return new JsonResponse($response, 200);
    }

    public function episodesAction(Request $request)
    {
        $query = $request->query->all();
        $em    = $this->getDoctrine()->getManager();
        $qb    = $em->createQueryBuilder();
        $expr  = $qb->expr();

        $params = [];

        $qb->select('e')
            ->from('ApiBundle:Episode', 'e');

        if (isset($query['id'])) {
            $qb->join('e.serial', 's')
                ->where($expr->eq('s.id', ':serialId'));
            $params['serialId'] = (int) $query['id'];
        } else {
            $response = RestController::createErrorResponse($request, 'Episodes not found');
            return new JsonResponse($response, 404);
        }

        if (isset($query['order'])) {
            if (strtoupper($query['order']) == 'ASC') {
                $order = 'ASC';
            } else {
                $order = 'DESC';
            }

            $qb->orderBy('e.seasonNumber', $order)
                ->addOrderBy('e.number', $order);
        }

        $qb->setParameters($params);
        $result = $qb->getQuery()->getResult();

        if ($result) {
            $response = RestController::createResponse($request, $result);
            return new JsonResponse($response, 200);
        } else {
            $response = RestController::createErrorResponse($request, 'Episodes not found');
            return new JsonResponse($response, 404);
        }
    }

    public function searchAction(Request $request, UserInterface $user = null)
    {
        $query = $request->query->all();

        $em   = $this->getDoctrine()->getManager();
        $qb   = $em->createQueryBuilder();
        $expr = $qb->expr();

        $qb->select('s')
            ->from('ApiBundle:Serial', 's');

        $params = [];

        if (isset($query['id'])) {
            $qb->andWhere($expr->in('s.id', ':serialsId'));

            $params['serialsId'] = explode(',', $query['id']);
        }

        if (isset($query['title'])) {
            $qb->andwhere($expr->like('s.title', ':title'));

            $params['title'] = '%' . $query['title'] . '%';
        }

        if (isset($query['originalTitle'])) {
            $qb->andwhere($expr->like('s.originalTitle', ':originalTitle'));

            $params['originalTitle'] = '%' . $query['originalTitle'] . '%';
        }

        if (isset($query['genre'])) {
            $qbG = $em->createQueryBuilder();

            $qbG->select('sg.id')
                ->from('ApiBundle:Serial', 'sg')
                ->leftJoin('sg.genre', 'genre')
                ->where($expr->in('genre.id', ':genresId'))
                ->groupBy('sg.id')
                ->having('COUNT(genre.id) = :genreCount');

            $genres               = explode(',', $query['genre']);
            $params['genresId']   = $genres;
            $params['genreCount'] = count($genres);

            $qb->andWhere($expr->in('s.id', $qbG->getDql()));
        }

        if (isset($query['country'])) {
            $qbC = $em->createQueryBuilder();

            $qbC->select('sc.id')
                ->from('ApiBundle:Serial', 'sc')
                ->leftJoin('sc.country', 'country')
                ->where($expr->in('country.id', ':countriesId'))
                ->groupBy('sc.id')
                ->having('COUNT(country.id) = :countriesCount');

            $countries                = explode(',', $query['country']);
            $params['countriesId']    = $countries;
            $params['countriesCount'] = count($countries);

            $qb->andWhere($expr->in('s.id', $qbC->getDql()));
        }

        if (isset($query['track']) && isset($user)) {
            if ($query['track'] == '*') {
                $qbC = $em->createQueryBuilder();

                $qbC->select('st.id')
                    ->from('ApiBundle:Serial', 'st')
                    ->leftJoin('st.user', 'user')
                    ->where($expr->eq('user.id', ':userId'));

                $params['userId'] = $user->getId();

                $qb->andWhere($expr->in('s.id', $qbC->getDql()));
            } else {
                $qbC = $em->createQueryBuilder();

                $qbC->select('st.id')
                    ->from('ApiBundle:Serial', 'st')
                    ->leftJoin('st.user', 'user')
                    ->where($expr->eq('user.id', ':userId'))
                    ->andWhere($expr->in('st.id', ':trackId'));

                $params['userId']  = $user->getId();
                $params['trackId'] = explode(',', $query['track']);

                $qb->andWhere($expr->in('s.id', $qbC->getDql()));
            }
        }

        if (isset($query['tvNetwork'])) {
            $qb->andWhere($expr->in('s.tvNetwork', ':tvNetwork'));

            $params['tvNetwork'] = explode(',', $query['tvNetwork']);
        }

        if (isset($query['yearStart'])) {
            $qb->andWhere($expr->in('s.yearStart', ':yearStart'));

            $params['yearStart'] = explode(',', $query['yearStart']);
        }

        if (isset($query['releaseDate'])) {
            $releaseDate = explode(',', $query['releaseDate']);
            //convert date
            array_walk($releaseDate, function (&$date, $i) {$date = date('Y-m-d H:i:s', strtotime($date));});

            $qbE = $em->createQueryBuilder();
            $qbE->select('es.id')
                ->distinct('es.id')
                ->from('ApiBundle:Episode', 'e')
                ->join('e.serial', 'es');

            if (count($releaseDate) == 1) {
                $qbE->where($expr->eq('e.releaseDate', ':releaseDate'));
                $params['releaseDate'] = $releaseDate[0];
            } else {
                if ($releaseDate[0] > $releaseDate[1]) {
                    $temp           = $releaseDate[1];
                    $releaseDate[1] = $releaseDate[0];
                    $releaseDate[0] = $temp;
                }
                $qbE->where($expr->between('e.releaseDate', ':releaseDateStart', ':releaseDateEnd'));
                $params['releaseDateStart'] = $releaseDate[0];
                $params['releaseDateEnd']   = $releaseDate[1];
            }

            $qb->andWhere($expr->in('s.id', $qbE->getDql()));
        }

        if (isset($query['sort'])) {
            $sort = true;
            if (isset($query['order']) && strtoupper($query['order']) == 'DESC') {
                $order = 'DESC';
            } else {
                $order = 'ASC';
            }

            switch ($query['sort']) {
                case 'serial.id':
                    $qb->orderBy('s.id', $order);
                    break;
                case 'serial.title':
                    $qb->orderBy('s.title', $order);
                    break;
                case 'serial.yearStart':
                    $qb->orderBy('s.yearStart', $order);
                    break;
                default:
                    $qb->orderBy('s.title', $order);
                    break;
            }
        }

        if (isset($query['offset'])) {
            $qb->setFirstResult($query['offset']);
        }

        if (isset($query['count'])) {
            $count = $query['count'] > 20 ? 20 : $query['count'];
            $qb->setMaxResults($query['count']);
        }

        // Если нет фильтров в запросе, то не искать
        // if ($params) {
        //   $qb->setParameters($params);
        // } else {
        //   $response = RestController::createErrorResponse($request, 'Serial not found');
        //   return new JsonResponse($response, 404);
        // }

        // Если нет фильтров в запросе, то вывести все
        if ($params || $sort == true) {
            $qb->setParameters($params);
        } else {
            $qb->addSelect('genre, country, tvNetwork, validationStatus')
                ->leftJoin('s.genre', 'genre')
                ->leftJoin('s.country', 'country')
                ->leftJoin('s.tvNetwork', 'tvNetwork')
                ->leftJoin('s.validationStatus', 'validationStatus')
                ->orderBy('s.id');
        }

        $result = $qb->getQuery()->getResult();

        if ($result) {
            foreach ($result as $serial) {
                if (isset($query['fields'])) {
                    $serial->setOutputFields(explode(',', $query['fields']));
                } else {
                    $serial->setOutputFields(['*']);
                }
            }
        } else {
            $response = RestController::createErrorResponse($request, 'Serial not found');
            return new JsonResponse($response, 404);
        }

        $serials = $result;

        $response = RestController::createResponse($request, $serials);

        return new JsonResponse($response, 200);
    }
}
