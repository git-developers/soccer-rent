<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\Tree\Builder\TreeMapper;

class TreeController extends BaseController
{

    public function index(TreeMapper $mapper)
    {
        $tree = $mapper->getDefaults();
        $parents = $this->em()->getRepository($tree['class_path'])->findAllParents();
        $entity = $this->getTreeEntities($tree, $parents);

        return $this->render(
            'AppBundle:Tree:index.html.twig',
            [
                'tree' => $tree,
                'entity' => $entity,
            ]
        );
    }

    public function create(Request $request, TreeMapper $mapper)
    {
        $tree = $mapper->getDefaults();
        $entity = new $tree['entity']();

        if (!$this->isXmlHttpRequest($request) && !is_object($entity)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $options = array_merge($tree['form_attr'], ['parent_id' => null]);
        $form = $this->createForm($tree['form_type'], $entity, $options);

        $form->handleRequest($request);


        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $tree['group_name']);
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
            $this->validateTemplate($tree['template_create']),
            [
                'formEntity' => $form->createView(),
            ]
        );
    }

    public function createChild(Request $request, TreeMapper $mapper)
    {
        $tree = $mapper->getDefaults();
        $entity = new $tree['entity']();

        if (!$this->isXmlHttpRequest($request) && !is_object($entity)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $id = $request->get('id');
        $options = array_merge($tree['form_attr'], ['parent_id' => $id]);
        $form = $this->createForm($tree['form_type'], $entity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $tree['group_name']);
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
            $this->validateTemplate($tree['template_create']),
            [
                'formEntity' => $form->createView(),
                'id' => $id,
            ]
        );
    }

    public function edit(Request $request, TreeMapper $mapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $id = $request->get('id');
        $tree = $mapper->getDefaults();
        $entity = $this->em()->getRepository($tree['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('TREE: Unable to find  entity.');
        }

        $options = array_merge($tree['form_attr'], ['parent_id' => $id]);
        $form = $this->createForm($tree['form_type'], $entity, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $tree['group_name']);
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
            $this->validateTemplate($tree['template_edit']),
            [
                'formEntity' => $form->createView(),
                'id' => $id,
            ]
        );
    }

    public function delete(Request $request, TreeMapper $mapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $errors = [];
        $status = self::AJAX_STATUS_ERROR;

        $id = $request->get('id');
        $tree = $mapper->getDefaults();
        $repository = $this->em()->getRepository($tree['class_path']);
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

    public function view(Request $request, TreeMapper $mapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $id = $request->get('id');
        $tree = $mapper->getDefaults();
        $entity = $this->em()->getRepository($tree['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('TREE: Unable to find  entity.');
        }

        return $this->render(
            $this->validateTemplate($tree['template_view']),
            [
                'entity' => $entity,
            ]
        );
    }

    public function info(Request $request, TreeMapper $mapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $tree = $mapper->getDefaults();

        return $this->render(
            $this->validateTemplate($tree['template_info']),
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