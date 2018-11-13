<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\TreeToAssign\Builder\BoxMapper;
use AppBundle\Services\TreeToAssign\Builder\BoxLeftMapper;
use AppBundle\Services\TreeToAssign\Builder\BoxRightMapper;

class TreeToAssignController extends BaseController
{

    const AJAX_STATUS_BOXLEFT_NOT_VALUE = 'box_left_no_value';

    public function index(BoxMapper $boxMapper, BoxLeftMapper $leftMapper, BoxRightMapper $rightMapper)
    {
        $box = $boxMapper->getDefaults();

        $boxLeft = $leftMapper->getDefaults();
        $leftEntity = $this->em()->getRepository($boxLeft['class_path'])->findAllParents();
        $leftEntity = $this->getTreeEntities($boxLeft, $leftEntity);

        $boxRight = $rightMapper->getDefaults();
        $rightEntity = $this->em()->getRepository($boxRight['class_path'])->findAll($boxRight['limit']);
        $rightEntity = $this->getSerializeDecode($rightEntity, $boxRight['group_name']);

        return $this->render(
            'AppBundle:TreeToAssign:index.html.twig',
            [
                'box' => $box,
                'boxLeft' => $boxLeft,
                'boxRight' => $boxRight,
                'leftEntity' => $leftEntity,
                'rightEntity' => $rightEntity,
            ]
        );
    }

    public function assign(Request $request, BoxMapper $boxMapper, BoxLeftMapper $leftMapper, BoxRightMapper $rightMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $box = $boxMapper->getDefaults();
        $boxLeft = $leftMapper->getDefaults();
        $boxRight = $rightMapper->getDefaults();

        $boxLeftId = $leftMapper->handleSelectedId($request);
        $boxRightIds = $rightMapper->handleSelectedId($request);
        $boxRightIdsToCreate = $boxMapper->getIdsToCreate($boxRightIds);
        $boxRightIdsToDelete = $boxMapper->getIdsToDelete($boxRightIds);

        $errors = [];
//        $assignedKeys = [];
        $status = self::AJAX_STATUS_ERROR;

        if(empty($boxLeftId)){
            $errors[] = self::AJAX_STATUS_BOXLEFT_NOT_VALUE;
        }

        try {
            $associativeBoxleftCollection = $box['assoc_boxleft_collection'];
            $associativeBoxrightCollection = $box['assoc_boxright_collection'];

            $boxLeftEntity = $this->em()->getRepository($boxLeft['class_path'])->findOneById($boxLeftId);

            if($boxLeftEntity){

                // remove entradas pasadas
                foreach ($boxRightIdsToDelete as $key => $boxRightId){
                    $boxRightEntity = $this->em()->getRepository($box['assoc_class_path'])->findAssociatedEntity($boxLeftId, $boxRightId);

                    if($boxRightEntity){
                        $this->remove($boxRightEntity);
                    }
                }

                // add nuevas entradas
                $associativeBoxRightIds = $this->em()->getRepository($box['assoc_class_path'])->findBoxRightIdsByBoxLeftValue($boxLeftId);
                foreach ($boxRightIdsToCreate as $key => $boxRightId){
                    if(!in_array($boxRightId, $associativeBoxRightIds)){

                        $entity = clone new $box['assoc_entity']();
                        $boxRightEntity = $this->em()->getRepository($boxRight['class_path'])->findOneById($boxRightId);
                        $entity->$associativeBoxleftCollection($boxLeftEntity);
                        $entity->$associativeBoxrightCollection($boxRightEntity);
                        $this->persist($entity);

//                        $assignedKeys[$boxRightId] = $entity->getIdIncrement();
                    }
                }

                $status = self::AJAX_STATUS_SUCCESS;
            }

        }catch (\Exception $e){
            $errors[] = $e->getMessage();
        }

        return $this->json([
            'status' => $status,
            'errors' => $errors,
        ]);
    }

    public function create(Request $request, BoxLeftMapper $leftMapper)
    {
        $boxLeft = $leftMapper->getDefaults();
        $entity = new $boxLeft['entity']();

        if (!$this->isXmlHttpRequest($request) && !is_object($entity)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $options = array_merge($boxLeft['form_attr'], ['parent_id' => null]);
        $form = $this->createForm($boxLeft['form_type'], $entity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $boxLeft['group_name']);
                    $status = self::AJAX_STATUS_SUCCESS;
                }else{
                    foreach ($form->getErrors(true) as $key => $error) {
                        if ($form->isRoot()) {
                            $errors[] = $error->getMessage();
                        } else {
                            $errors[] = $error->getMessage();
                        }
                    }
                }

            }catch (\Exception $e){
                $errors[] = $e->getMessage();
            }

            return $this->json([
                'status' => $status,
                'errors' => $errors,
                'entity' => $entityJson,
            ]);
        }

        return $this->render(
            $this->validateTemplate($boxLeft['template_create']),
            [
                'formEntity' => $form->createView(),
            ]
        );
    }

    public function createChild(Request $request, BoxLeftMapper $leftMapper)
    {
        $boxLeft = $leftMapper->getDefaults();
        $entity = new $boxLeft['entity']();

        if (!$this->isXmlHttpRequest($request) && !is_object($entity)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $parentId = $request->get('id');
        $options = array_merge($boxLeft['form_attr'], ['parent_id' => $parentId]);
        $form = $this->createForm($boxLeft['form_type'], $entity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $boxLeft['group_name']);
                    $status = self::AJAX_STATUS_SUCCESS;
                }else{
                    foreach ($form->getErrors(true) as $key => $error) {
                        if ($form->isRoot()) {
                            $errors[] = $error->getMessage();
                        } else {
                            $errors[] = $error->getMessage();
                        }
                    }
                }

            }catch (\Exception $e){
                $errors[] = $e->getMessage();
            }

            return $this->json([
                'status' => $status,
                'errors' => $errors,
                'entity' => $entityJson,
                'parent_id' => $parentId,
            ]);
        }

        return $this->render(
            $this->validateTemplate($boxLeft['template_create']),
            [
                'formEntity' => $form->createView(),
                'id' => $parentId,
            ]
        );
    }

    public function edit(Request $request, BoxLeftMapper $leftMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $id = $request->get('id');
        $boxLeft = $leftMapper->getDefaults();
        $entity = $this->em()->getRepository($boxLeft['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('TREE: Unable to find  entity.');
        }

        $options = array_merge($boxLeft['form_attr'], ['parent_id' => $id]);
        $form = $this->createForm($boxLeft['form_type'], $entity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $boxLeft['group_name']);
                    $status = self::AJAX_STATUS_SUCCESS;
                }else{
                    foreach ($form->getErrors(true) as $key => $error) {
                        if ($form->isRoot()) {
                            $errors[] = $error->getMessage();
                        } else {
                            $errors[] = $error->getMessage();
                        }
                    }
                }

            }catch (\Exception $e){
                $errors[] = $e->getMessage();
            }

            return $this->json([
                'status' => $status,
                'errors' => $errors,
                'entity' => $entityJson,
                'id' => $id,
            ]);
        }

        return $this->render(
            $this->validateTemplate($boxLeft['template_edit']),
            [
                'formEntity' => $form->createView(),
                'id' => $id,
            ]
        );
    }

    public function delete(Request $request, BoxLeftMapper $leftMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $errors = [];
        $status = self::AJAX_STATUS_ERROR;

        $id = $request->get('id');
        $boxLeft = $leftMapper->getDefaults();
        $repository = $this->em()->getRepository($boxLeft['class_path']);
        $entity = $repository->find($id);

        try {

            if($entity){
                $entity->setIsActive(false);
//                $this->remove($entity);
                $this->persist($entity);

                $children = $repository->findAllByParent($id);

                if(is_array($children)){
                    foreach ($children as $key => $category){
                        $category->setIsActive(false);
                        $this->persist($entity);
                    }
                }

                $status = self::AJAX_STATUS_SUCCESS;
            }

        }catch (\Exception $e){
            $errors[] = $e->getMessage();
        }

        return $this->json([
            'status' => $status,
            'errors' => $errors,
            'id' => $id,
        ]);
    }

    public function boxRightSearch(Request $request, BoxMapper $boxMapper, BoxLeftMapper $leftMapper, BoxRightMapper $rightMapper)
    {
        $q = $rightMapper->handleSearchValue($request);

        $boxRight = $rightMapper->getDefaults();
        $rightEntity = $this->em()->getRepository($boxRight['class_path'])->search($q, $boxRight['limit']);
        $rightEntity = $this->getSerializeDecode($rightEntity, $boxRight['group_name']);

        $boxRightAssigned = $this->boxRightAssigned($request, $boxMapper, $leftMapper, $rightMapper);

        return $this->render(
            'AppBundle:TreeToAssign:Li/box_right.html.twig',
            [
                'boxRight' => $boxRight,
                'rightEntity' => $rightEntity,
                'boxRightAssigned' => $boxRightAssigned,
            ]
        );
    }

    private function boxRightAssigned(Request $request, BoxMapper $boxMapper, BoxLeftMapper $leftMapper, BoxRightMapper $rightMapper)
    {
        $box = $boxMapper->getDefaults();
        $boxRight = $rightMapper->getDefaults();

        $boxLeftId = $leftMapper->handleSelectedId($request);
        $leftHasRight = $this->getLeftHasRightValues($boxLeftId, $boxMapper);

        $keys = [];
        $keys[BoxMapper::ID_ASSOCIATIVE] = [];
        $keys[BoxMapper::ID_LEFT_HAS_RIGHT] = [];
        foreach ($leftHasRight as $key => $value){

            $keys[BoxMapper::ID_ASSOCIATIVE][] = isset($value[$box['assoc_group_name_associative']]) ? $value[$box['assoc_group_name_associative']] : [];

            $value = isset($value[$boxRight['group_name']]) ? $value[$boxRight['group_name']] : [];
            $id = isset($value['id_increment']) ? $value['id_increment'] : null;

            $keys[BoxMapper::ID_LEFT_HAS_RIGHT][] = $id;
        }

        return $keys;
    }

    public function boxleftHasBoxright(Request $request, BoxMapper $boxMapper, BoxLeftMapper $leftMapper, BoxRightMapper $rightMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $boxLeftId = $request->get('id');
        $boxRight = $rightMapper->getDefaults();
        $leftHasRight = $this->getLeftHasRightValues($boxLeftId, $boxMapper);

        return $this->render(
            'AppBundle:TreeToAssign:Li/box_right.html.twig',
            [
                'isAssigned' => true,
                'boxRight' => $boxRight,
                'rightEntity' => $leftHasRight,
                //                'action' => $box['action_delete'],
            ]
        );

    }

    private function getLeftHasRightValues($boxLeftId, BoxMapper $boxMapper)
    {
        $box = $boxMapper->getDefaults();
        $leftHasRight = $this->em()->getRepository($box['assoc_class_path'])->findBoxleftHasBoxright($boxLeftId);
        return $this->getSerializeDecode($leftHasRight, $box['assoc_group_name']);
    }

    public function info(Request $request, BoxMapper $boxMapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $box = $boxMapper->getDefaults();

        return $this->render(
            $this->validateTemplate($box['template_info']),
            [
                'xxx' => '',
            ]
        );
    }

    private function getTreeEntities(array $tree, $parents)
    {
        if(is_null($parents)){
            $parents = [];
        }

        $entity = [];
        foreach ($parents as $key => $parent){

            $entity[$key]['parent'] = $this->getSerializeDecode($parent, $tree['group_name']);

            $children = $this->em()->getRepository($tree['class_path'])->findAllByParent($parent);
            $entity[$key]['children'] = $this->getTreeEntities($tree, $children);
        }

        return $entity;
    }

    protected function getFormTemplate($view, $form = 'form')
    {
        $bundle = $this->getBundleName();
        return $bundle . ':' . $view . ':Form/' . $form . '.html.twig';
    }

    protected function getInformativeTemplate($view, $action)
    {
        $bundle = $this->getBundleName();
        return $bundle . ':' . $view . ':Informative/' . strtolower($action) . '.html.twig';
    }

}