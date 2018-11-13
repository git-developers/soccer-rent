<?php

namespace AppBundle\Controller;

use AppBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PointOfSale;
use AppBundle\Form\PointOfSaleType;
use AppBundle\Services\Crud\Builder\CrudMapper;

class PointOfSaleController extends CrudController {

    const CLASS_PATH = PointOfSale::class;
    const GROUP_NAME = 'pointofsale';
    const VIEW = 'PointOfSale';
    const FORM_TYPE = PointOfSaleType::class;
    const LIMIT_POINT_OF_SALE = 20;


    public function indexAction()
    {
        $crud = $this->get('app.service.crud');
        $crudMapper = $crud->getCrudMapper();
        $dataTable = $crud->getDataTableMapper();

        $crudMapper
            ->add('modal_info_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('section_title', 'Gestionar canchas')
            ->add('section_icon', 'home')
            ->add('class_path', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
            ->add('section_box_class', 'primary')
            ->add('route_create', $this->generateUrl('app_pointofsale_create'))
            ->add('route_edit', $this->generateUrl('app_pointofsale_edit'))
            ->add('route_delete', $this->generateUrl('app_pointofsale_delete'))
            ->add('route_view', $this->generateUrl('app_pointofsale_view'))
            ->add('route_info', $this->generateUrl('app_pointofsale_info'))
            ->add('test', 'test', [
                'label' => '',
            ])
        ;

        $dataTable
            ->addColumn('#', " '<span class=\"badge bg-blue\">' + obj.id_increment + '</span>' ")
            ->addColumn('image', " '<img src=\"' + obj.image + '\" class=\"img-responsive\" style=\"max-height: 50px\" >' ")
            ->addColumn('Code', " '<small class=\"label label-success\">' + obj.code + '</small>' ")
            ->addColumn('Name', 'obj.name')
            ->addColumn('latitude', 'obj.latitude', [
                'icon' => 'map-marker'
            ])
            ->addColumn('longitude', 'obj.longitude', [
                'icon' => 'map-marker'
            ])
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
