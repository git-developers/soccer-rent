<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PointOfSale;
use AppBundle\Entity\Reserva;


class MapController extends BaseController
{

    public function indexAction(Request $request)
    {


        echo "POLLO:: <pre>";
        print_r(33333);
        exit;




        $entity = $this->em()->getRepository(PointOfSale::class)->findAll();
        $pointOfSales = $this->getSerializeDecode($entity, 'pointofsale');

        $entities = $this->em()->getRepository(Reserva::class)->findAll();

        if(!empty($entities)){
            $this->flashWarning('Notificación: tiene reservas pendientes, reconfirmar su reservación.');
        }




        $response = $this->render(
            'AppBundle:Map:index.html.twig',
            [
                'point_of_sales' => $pointOfSales,
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    public function detailAction(Request $request, $pdvId)
    {
        $pdv = $this->em()->getRepository(PointOfSale::class)->findOneById($pdvId);

        if(!$pdv){
            throw $this->createNotFoundException('Pdv: no existe');
        }

        $pdv = $this->getSerializeDecode($pdv, 'pointofsale');

        $response = $this->render(
            'AppBundle:Map:detail.html.twig',
            [
                'pdv' => $pdv,
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

}

