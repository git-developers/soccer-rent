<?php

namespace AppBundle\Controller;

use AppBundle\Controller\TreeToAssignController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategoryHasProduct;
use AppBundle\Form\CategoryType;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;


class CartCategoryHasProductController extends TreeToAssignController {

    const ASSOC_ENTITY = CategoryHasProduct::class;
    const ASSOC_GROUP_NAME = 'category_has_product';
    const ASSOC_CLASS_PATH = CategoryHasProduct::class;

    const BOXLEFT_TITLE = 'Categorias';
    const BOXLEFT_CLASS_PATH = Category::class;
    const BOXLEFT_FORM_TYPE = CategoryType::class;
    const BOXLEFT_GROUP_NAME = 'category';
    const BOXLEFT_VIEW = 'Category';
    const BOXLEFT_COLLECTION = 'setCategory';
    const BOXLEFT_LIMIT = 20;

    const BOXRIGHT_TITLE = 'Productos';
    const BOXRIGHT_CLASS_PATH = Product::class;
    const BOXRIGHT_GROUP_NAME = 'product';
    const BOXRIGHT_COLLECTION = 'setProduct';
    const BOXRIGHT_LIMIT = 20;

    public function indexAction()
    {
        $tree = $this->get('app.service.treetoassign');
        $boxMapper = $tree->getBoxMapper();
        $leftMapper = $tree->getBoxLeftMapper();
        $rightMapper = $tree->getBoxRightMapper();

        $leftMapper
            ->add('box_title', self::BOXLEFT_TITLE)
            ->add('box_icon', 'sitemap')
            ->add('class_path', self::BOXLEFT_CLASS_PATH)
            ->add('group_name', self::BOXLEFT_GROUP_NAME)
            ->add('route_create', $this->generateUrl('app_categorytreetoassign_create'))
            ->add('route_create_child', $this->generateUrl('app_categorytreetoassign_create_child'))
            ->add('route_edit', $this->generateUrl('app_categorytreetoassign_edit'))
            ->add('route_delete', $this->generateUrl('app_categorytreetoassign_delete'))
            ->add('route_view', $this->generateUrl('app_categorytreetoassign_view'))
            ->add('route_select_item', $this->generateUrl('app_categorytreetoassign_boxleft_has_boxright'))
        ;

        $rightMapper
            ->add('box_title', self::BOXRIGHT_TITLE)
            ->add('box_icon', 'cube')
            ->add('class_path', self::BOXRIGHT_CLASS_PATH)
            ->add('group_name', self::BOXRIGHT_GROUP_NAME)
            ->add('route_search', $this->generateUrl('app_categorytreetoassign_boxright_search'))
            ->add('route_select_item', $this->generateUrl('app_categorytreetoassign_assign'))
        ;

        return parent::index($boxMapper, $leftMapper, $rightMapper);
    }

    public function assignAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $boxMapper = $tree->getBoxMapper();
        $leftMapper = $tree->getBoxLeftMapper();
        $rightMapper = $tree->getBoxRightMapper();

        $boxMapper
            ->add('assoc_entity', self::ASSOC_ENTITY)
            ->add('assoc_class_path', self::ASSOC_CLASS_PATH)
            ->add('assoc_group_name', self::ASSOC_GROUP_NAME)
            ->add('assoc_boxleft_collection', self::BOXLEFT_COLLECTION)
            ->add('assoc_boxright_collection', self::BOXRIGHT_COLLECTION)
        ;

        $leftMapper
            ->add('class_path', self::BOXLEFT_CLASS_PATH)
        ;

        $rightMapper
            ->add('class_path', self::BOXRIGHT_CLASS_PATH)
        ;

        return parent::assign($request, $boxMapper, $leftMapper, $rightMapper);
    }

    public function createAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $leftMapper = $tree->getBoxLeftMapper();

        $leftMapper
            ->add('template_create', $this->getFormTemplate(self::BOXLEFT_VIEW))
            ->add('form_type', self::BOXLEFT_FORM_TYPE)
            ->add('group_name', self::BOXLEFT_GROUP_NAME)
            ->add('entity', self::BOXLEFT_CLASS_PATH)
        ;

        return parent::create($request, $leftMapper);
    }

    public function createChildAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $leftMapper = $tree->getBoxLeftMapper();

        $leftMapper
            ->add('template_create', $this->getFormTemplate(self::BOXLEFT_VIEW))
            ->add('form_type', self::BOXLEFT_FORM_TYPE)
            ->add('group_name', self::BOXLEFT_GROUP_NAME)
            ->add('entity', self::BOXLEFT_CLASS_PATH)
        ;

        return parent::createChild($request, $leftMapper);
    }

    public function editAction(Request $request)
    {

        $tree = $this->get('app.service.treetoassign');
        $leftMapper = $tree->getBoxLeftMapper();

        $leftMapper
            ->add('template_edit', $this->getFormTemplate(self::BOXLEFT_VIEW))
            ->add('form_type', self::BOXLEFT_FORM_TYPE)
            ->add('class_path', self::BOXLEFT_CLASS_PATH)
            ->add('group_name', self::BOXLEFT_GROUP_NAME)
        ;

        return parent::edit($request, $leftMapper);
    }

    public function deleteAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $leftMapper = $tree->getBoxLeftMapper();

        $leftMapper
            ->add('class_path', self::BOXLEFT_CLASS_PATH)
        ;

        return parent::delete($request, $leftMapper);
    }

    public function boxRightSearchAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $boxMapper = $tree->getBoxMapper();
        $leftMapper = $tree->getBoxLeftMapper();
        $rightMapper = $tree->getBoxRightMapper();

        $boxMapper
            ->add('assoc_class_path', self::ASSOC_ENTITY)
            ->add('assoc_group_name', self::ASSOC_GROUP_NAME)
        ;

        $rightMapper
            ->add('class_path', self::BOXRIGHT_CLASS_PATH)
            ->add('group_name', self::BOXRIGHT_GROUP_NAME)
            ->add('limit', self::BOXRIGHT_LIMIT)
        ;

        return parent::boxRightSearch($request, $boxMapper, $leftMapper, $rightMapper);
    }

    public function boxleftHasBoxrightAction(Request $request)
    {
        $tree = $this->get('app.service.treetoassign');
        $boxMapper = $tree->getBoxMapper();
        $leftMapper = $tree->getBoxLeftMapper();
        $rightMapper = $tree->getBoxRightMapper();

        $boxMapper
            ->add('assoc_class_path', self::ASSOC_ENTITY)
            ->add('assoc_group_name', self::ASSOC_GROUP_NAME)
        ;

        $rightMapper
            ->add('group_name', self::BOXRIGHT_GROUP_NAME)
        ;

        return parent::boxleftHasBoxright($request, $boxMapper, $leftMapper, $rightMapper);
    }

}
