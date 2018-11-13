<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class RouteController extends BaseController
{

    public function indexAction(Request $request)
    {

        $response = $this->render(
            'AppBundle:Route:index.html.twig',
            [
                'modules' => '',
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

}

