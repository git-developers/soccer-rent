<?php

namespace AppBundle\Controller;

use AppBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Profile;
use AppBundle\Form\ProfileType;
use AppBundle\Services\Crud\Builder\CrudMapper;


class ProfileController extends CrudController
{

    const CLASS_PATH = Profile::class;
    const GROUP_NAME = 'profile';
    const VIEW = 'Profile';
    const FORM_TYPE = ProfileType::class;


    public function indexAction()
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();
        $dataTable = $crud->getDataTableMapper();

        $crudMapper
            ->add('modal_info_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('modal_edit_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('modal_create_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('section_title', 'Gestionar profiles')
            ->add('section_icon', 'expeditedssl')
            ->add('class_path', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
            ->add('section_box_class', 'primary')
            ->add('route_create', $this->generateUrl('app_profile_create'))
            ->add('route_edit', $this->generateUrl('app_profile_edit'))
            ->add('route_delete', $this->generateUrl('app_profile_delete'))
            ->add('route_view', $this->generateUrl('app_profile_view'))
            ->add('route_info', $this->generateUrl('app_profile_info'))
            ->add('test', 'test', [
                'label' => '',
            ])
        ;

        $dataTable
            ->addColumn('#', " '<span class=\"badge bg-blue\">' + obj.id_increment + '</span>' ")
            ->addColumn('Nombre del perfil', 'obj.name')
            ->addColumn('Slug', 'obj.slug')
            ->addColumn('Creado', 'obj.created_at', [
                'icon' => 'calendar'
            ])
            ->addButtonTable(['edit', 'delete'], 'obj.id_increment')
            ->addButtonHeader(['create', 'info'])
            ->addRowCallBack('id', 'aData.id_increment')
            ->addRowCallBack('data-id', 'aData.id_increment')
            ->addRowCallBack('class', ' "alert" ')
        ;

        $dataTable->setOptions([
            'pageLength' => 20,
        ]);

        return parent::index($crudMapper, $dataTable);

    }

    public function createAction(Request $request)
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_create', $this->getFormTemplate(self::VIEW))
            ->add('form_type', self::FORM_TYPE)
            ->add('entity', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
            ->add('test', 'test', [
                'label' => '',
            ])
        ;

        return parent::create($request, $crudMapper);
    }

    public function editAction(Request $request)
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_edit', $this->getFormTemplate(self::VIEW))
            ->add('form_type', self::FORM_TYPE)
            ->add('form_attr', [])
            ->add('class_path', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
        ;

        return parent::edit($request, $crudMapper);
    }

    public function deleteAction(Request $request)
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('class_path', self::CLASS_PATH)
        ;

        return parent::delete($request, $crudMapper);
    }

    public function infoAction(Request $request)
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_info', $this->getInformativeTemplate(self::VIEW, 'info'))
        ;

        return parent::info($request, $crudMapper);
    }

    public function viewAction(Request $request)
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_view', $this->getInformativeTemplate(self::VIEW, 'view'))
            ->add('class_path', self::CLASS_PATH)
        ;

        return parent::view($request, $crudMapper);
    }

}
