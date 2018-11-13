<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Role;
use AppBundle\Entity\Profile;
use Doctrine\ORM\EntityManager;


class ProfileType extends AbstractType
{

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getRoles() {
        $roleRepository = $this->em->getRepository(Role::class);
        return $roleRepository->findAll();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del perfil',
                'label_attr' => ['class' => ''],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'e.g. admin, editor, runner',
                ],
            ])
            ->add('role', EntityType::class, [
                'choices' => $this->getRoles(),
                'class' => Role::class,
                'required' => true,
                'empty_data' => null,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Profiles roles',
                'label_attr' => ['class' => ''],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => [
                    'class' => 'btn bg-olive margin',
                ],
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class
        ]);
    }

}
