<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\PointOfSale;
use AppBundle\Entity\Reserva;
use Doctrine\ORM\EntityManager;

class ReservaType extends AbstractType
{

    protected $em;
    protected $pdvId;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    public function selectedPdv($id) {
        return $this->em->getRepository(PointOfSale::class)->find($id);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->pdvId = $options['pdv_id'];

        $builder->setMethod('POST');

        $builder
            ->add('pointOfSale', EntityType::class, [
                'class' => PointOfSale::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->findAllObjects();
                },
                'data' => $this->selectedPdv($this->pdvId),
                'placeholder' => '[ Escoge una opción ]',
                'empty_data' => null,
                'required' => true,
                'label' => 'Cancha',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                ],
            ])
            ->add('inicio', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de reserva',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'inicio',
                ],
            ])
            ->add('time', TextType::class, [
                'label' => 'time',
                'error_bubbling' => true,
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'time',
                ],
            ])
//            ->add('name', TextType::class, [
//                'label' => 'name',
//                'label_attr' => [
//                    'class' => ''
//                ],
//                'attr' => [
//                    'class' => 'form-control',
//                    'placeholder' => 'name',
//                ],
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reservar',
                'attr' => [
                    'class' => 'btn btn-info pull-right',
                ],
            ]);
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class
        ]);
        $resolver->setRequired('pdv_id');
    }

}
