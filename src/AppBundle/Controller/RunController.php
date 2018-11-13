<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RunController extends Controller
{

    public function indexAction()
    {

        return $this->render(
            'AppBundle:Run:index.html.twig',
            [
                'categoryHasProduct' => '',
            ]
        );
    }


}
