<?php

namespace ApiBundle\Service;

class Helper
{
    public function getUserId($request, $user)
    {
        if ($request->query->has('id')) {
            $id = (int) $request->query->get('id');
        } else if ($request->request->has('id')) {
            $id = (int) $request->request->get('id');
        } else if ($user) {
            $id = $user->getId();
        } else {
            $id = 0;
        }
        return $id;
    }
}
