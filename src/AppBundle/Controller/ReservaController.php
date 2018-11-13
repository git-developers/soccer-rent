<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PointOfSale;
use AppBundle\Entity\Reserva;
use AppBundle\Form\ReservaType;
use Symfony\Component\Form\FormError;


class ReservaController extends BaseController
{

    public function createAction(Request $request, $pdvId)
    {
        $pdv = $this->em()->getRepository(PointOfSale::class)->findOneById($pdvId);

        if(!$pdv){
            throw $this->createNotFoundException('Pdv: no existe');
        }

        $pdv = $this->getSerializeDecode($pdv, 'pointofsale');

        $entity = new Reserva();
        $form = $this->createForm(ReservaType::class, $entity, ['pdv_id' => $pdvId]);
        $form->handleRequest($request);

        $entities = $this->em()->getRepository(Reserva::class)->findAll();

        foreach ($entities as $key => $value){
            if($entity->getTime() == $value->getTime()){
                $form->get('time')->addError(new FormError('La fecha fue registrada anteriormente.'));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $entity->setUserId($user->getId());

            $this->persist($entity);
            return $this->redirectToRoute('app_reserva_list');
        }

        $response = $this->render(
            'AppBundle:Reserva:form.html.twig',
            [
                'pdv' => $pdv,
                'entity' => null,
                'times' => $this->times(),
                'formEntity' => $form->createView(),
                'header' => 'Crear una reserva',
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    public function editAction(Request $request, $reservaId)
    {
        $entity = $this->em()->getRepository(Reserva::class)->findOneById($reservaId);

        if(!$entity){
            throw $this->createNotFoundException('Reserva: no existe');
        }

        $pdvId = $entity->getPointOfSale()->getIdIncrement();
        $pdv = $this->em()->getRepository(PointOfSale::class)->findOneById($pdvId);

        $form = $this->createForm(ReservaType::class, $entity, ['pdv_id' => $pdvId]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->persist($entity);
            return $this->redirectToRoute('app_reserva_list');
        }

        $response = $this->render(
            'AppBundle:Reserva:form.html.twig',
            [
                'pdv' => $pdv,
                'entity' => $entity,
                'times' => $this->times(),
                'formEntity' => $form->createView(),
                'header' => 'Editar una reserva',
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    public function listAction(Request $request)
    {

        $user = $this->getUser();

        $entities = $this->em()->getRepository(Reserva::class)->findAllByUser($user->getId());
        $entities = $this->getSerializeDecode($entities, 'reserva');

        $response = $this->render(
            'AppBundle:Reserva:list.html.twig',
            [
                'entities' => $entities,
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    public function deleteAction(Request $request)
    {

        $id = $request->get('id');

        $entity = $this->em()->getRepository(Reserva::class)->findOneById($id);

        if($entity){
            $entity->setIsActive(0);
            $this->persist($entity);
        }

        return $this->json([
            'status' => true
        ]);
    }

    public function times()
    {
        return [
            '8:00 - 9:00',
            '9:00 - 10:00',
            '10:00 - 11:00',
            '11:00 - 12:00',
            '12:00 - 13:00',
            '13:00 - 14:00',
            '14:00 - 15:00',
            '15:00 - 16:00',
            '16:00 - 17:00',
            '17:00 - 18:00',
            '18:00 - 19:00',
            '19:00 - 20:00',
            '20:00 - 21:00',
            '21:00 - 22:00',
            '22:00 - 23:00',
            '23:00 - 00:00',
        ];
    }

}

