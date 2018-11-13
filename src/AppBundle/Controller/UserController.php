<?php

namespace AppBundle\Controller;

use AppBundle\Controller\CrudUserController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Crud\Builder\CrudMapper;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class UserController extends CrudUserController {

    const CLASS_PATH = User::class;
    const GROUP_NAME = 'user';
    const VIEW = 'User';
    const FORM_TYPE = UserType::class;
    const LIMIT_USER = 20;
    const GROUPS_VALIDATOR = 'registration_admin';


    public function indexAction()
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();
        $dataTable = $crud->getDataTableMapper();

        $crudMapper
            ->add('section_title', 'Gestionar usuarios')
            ->add('section_icon', 'user')
            ->add('class_path', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
            ->add('section_box_class', 'primary')
            ->add('route_create', $this->generateUrl('app_user_create'))
            ->add('route_edit', $this->generateUrl('app_user_edit'))
            ->add('route_view', $this->generateUrl('app_user_view'))
            ->add('route_delete', $this->generateUrl('app_user_delete'))
            ->add('route_info', $this->generateUrl('app_user_info'))
            ->add('route_change_password', $this->generateUrl('app_user_change_password'))
            ->add('modal_info_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('modal_create_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('modal_edit_size', CrudMapper::MODAL_SIZE_LARGE)
            ->add('test', 'test', [
                'label' => '',
            ])
        ;

        $dataTable
            ->addColumn('#', " '<span class=\"badge bg-blue\">' + obj.id + '</span>' ")
//            ->addColumn('Cliente', 'obj.client', [
//                'property' => '"<span class=\"label label-primary\">" + obj.client.id_increment  + "</span> " + obj.client.name',
//                'icon' => 'industry',
//            ])
            ->addColumn('Name', 'obj.name')
            ->addColumn('LastName', 'obj.last_name')
            ->addColumn('Username', 'obj.username')
            ->addColumn('Creado', 'obj.created_at', [
                'icon' => 'calendar'
            ])
            ->addButtonTable(['edit', 'delete', 'change_password'], 'obj.id_increment')
            ->addButtonHeader(['create', 'info'])
            ->addRowCallBack('id', 'aData.id')
            ->addRowCallBack('data-id', 'aData.id')
            ->addRowCallBack('class', ' "alert" ')
        ;

//        $dataTable->setOptions([
//            'pageLength' => 20,
//        ]);

        return parent::index($crudMapper, $dataTable);
    }

    public function createAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_create', $this->getFormTemplate(self::VIEW))
            ->add('form_type', self::FORM_TYPE)
            ->add('entity', self::CLASS_PATH)
            ->add('group_name', self::GROUP_NAME)
            ->add('groups_validator', [self::GROUPS_VALIDATOR])
        ;

        return parent::create($request, $crudMapper);
    }

    public function editAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
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

    public function changePasswordAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_edit', $this->getFormTemplate(self::VIEW, 'form_change_password'))
            ->add('form_attr', [])
            ->add('class_path', self::CLASS_PATH)
        ;

        return parent::changePassword($request, $crudMapper);
    }

    public function deleteAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('class_path', self::CLASS_PATH)
        ;

        return parent::delete($request, $crudMapper);
    }

    public function infoAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_info', $this->getInformativeTemplate(self::VIEW, 'info'))
        ;

        return parent::info($request, $crudMapper);
    }

    public function viewAction(Request $request)
    {
        $crud = $this->get('app.service.cruduser');
        $crudMapper = $crud->getCrudMapper();

        $crudMapper
            ->add('template_view', $this->getInformativeTemplate(self::VIEW, 'view'))
            ->add('class_path', self::CLASS_PATH)
        ;

        return parent::view($request, $crudMapper);
    }

    public function searchAction(Request $request)
    {
        $q = $request->get('q');
        $users = $this->em()->getRepository(self::CLASS_PATH)->search($q, self::LIMIT_USER);
        $users = $this->getSerializeDecode($users, self::GROUP_NAME);

        return $this->render(
            'AppBundle:User:li_list_users.html.twig',
            [
                'users' => $users,
            ]
        );
    }

}
