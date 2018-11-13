<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{

    public function indexAction(Request $request)
    {

//        echo 'Current script owner: ' . get_current_user();
//
//        exit;

        return $this->redirectUrl('app_map_index');

        $response = $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'modules' => '',
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /*

    /**
     * @Route("/", name="homepage")

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    */
}
