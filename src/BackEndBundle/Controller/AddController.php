<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddController extends Controller
{
    public function indexAction(Request $request)
    {
        $title     = $request->get('title');
        $link      = $request->get('link');
        if (!empty($title) && !empty($link)) {
            $text = sprintf('Сериал: %s, ссылка: %s. Заявку добавил: %s %s'.PHP_EOL, $title, $link, $this->getUser()->getUsername(), date('d.m.Y G:i'));
            file_put_contents('new-serials.txt', $text, FILE_APPEND);

            return $this->render('BackEndBundle:Add:index.html.twig', [
                'notify' => ['status' => 'success', 'message' => 'Сериал появится на сайте после проверки его человеком'],
            ]);
        } else {
            return $this->render('BackEndBundle:Add:index.html.twig');
        }
    }

}
