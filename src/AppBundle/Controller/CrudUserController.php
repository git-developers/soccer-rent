<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\CrudUser\Builder\CrudUserMapper;
use AppBundle\Services\CrudUser\Builder\DataTableMapper;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Entity\ChangePassword2;

class CrudUserController extends BaseController
{

    public function index(CrudUserMapper $crudMapper, DataTableMapper $dataTable)
    {
        $crud = $crudMapper->getDefaults();
        $entity = $this->em()->getRepository($crud['class_path'])->findAll();
        $entity = $this->getSerialize($entity, $crud['group_name']);
        $dataTable->setData($entity);

        return $this->render(
            'AppBundle:CrudUser:index.html.twig',
            [
                'crud' => $crud,
                'dataTable' => $dataTable,
            ]
        );

    }

    public function create(Request $request, CrudUserMapper $crudMapper)
    {
        $crud = $crudMapper->getDefaults();
        $entity = new $crud['entity']();

        if (!$this->isXmlHttpRequest($request) && !is_object($entity)) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $form = $this->createForm($crud['form_type'], $entity, $crud['form_attr']);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{
                $validator = $this->get('validator');
                $errorsValidator = $validator->validate($entity, null, $crud['groups_validator']);

                $validatorStatus = true;
                if(count($errorsValidator) > 0){
                    $validatorStatus = false;
                    foreach ($errorsValidator as $key => $error){
                        $errors[] = $error->getMessage();
                    }
                }

                if ($form->isValid() && $validatorStatus) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $crud['group_name']);
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
            $this->validateTemplate($crud['template_create']),
            [
                'formEntity' => $form->createView(),
                'crud' => $crud,
            ]
        );
    }

    public function edit(Request $request, CrudUserMapper $crudMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }

        $id = $request->get('id');
        $crud = $crudMapper->getDefaults();


//        echo '<pre> POLLO:: ';
//        print_r($id);
//        exit;


        $entity = $this->em()->getRepository($crud['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('CRUD: Unable to find  entity.');
        }

        $form = $this->createForm($crud['form_type'], $entity, $crud['form_attr']);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {
                    $this->persist($entity);
                    $entityJson = $this->getSerializeDecode($entity, $crud['group_name']);
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
            $this->validateTemplate($crud['template_edit']),
            [
                'formEntity' => $form->createView(),
                'crud' => $crud,
                'id' => $id,
            ]
        );
    }

    public function changePassword(Request $request, CrudUserMapper $crudMapper)
    {
        if (!$this->isXmlHttpRequest()) {
            throw $this->createAccessDeniedException(self::ACCESS_DENIED_MSG);
        }


        $id = $request->get('id');
        $crud = $crudMapper->getDefaults();
        $entity = $this->em()->getRepository($crud['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('CRUD USER: Unable to find  entity.');
        }

        $data = new ChangePassword2();
        $form = $this->createForm(ChangePasswordType::class, $data, $crud['form_attr']);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $errors = [];
            $entityJson = null;
            $status = self::AJAX_STATUS_ERROR;

            try{

                if ($form->isValid()) {

                    $plainPassword = $data->getNewPassword();
                    $encoder = $this->container->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($entity, $plainPassword);
                    $entity->setPassword($encoded);

                    $this->persist($entity);
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
                'id' => $id,
            ]);
        }

        return $this->render(
            $this->validateTemplate($crud['template_edit']),
            [
                'formEntity' => $form->createView(),
                'crud' => $crud,
                'id' => $id,
            ]
        );
    }

    public function delete(Request $request, CrudUserMapper $crudMapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            return;
        }

        $errors = [];
        $status = self::AJAX_STATUS_ERROR;

        $id = $request->get('id');
        $crud = $crudMapper->getDefaults();
        $repository = $this->em()->getRepository($crud['class_path']);
        $entity = $repository->find($id);

        try {

            if($entity){
                $entity->setIsActive(false);
//                $this->remove($entity);
                $this->persist($entity);

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

    public function view(Request $request, CrudUserMapper $crudMapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            return;
        }

        $id = $request->get('id');
        $crud = $crudMapper->getDefaults();
        $entity = $this->em()->getRepository($crud['class_path'])->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('CRUD: Unable to find  entity.');
        }

        return $this->render(
            $this->validateTemplate($crud['template_view']),
            [
                'entity' => $entity,
            ]
        );
    }

    public function info(Request $request, CrudUserMapper $crudMapper)
    {
        if (!$this->isXmlHttpRequest($request)) {
            return;
        }

        $crud = $crudMapper->getDefaults();

        return $this->render(
            $this->validateTemplate($crud['template_info']),
            [
                'xxx' => '',
            ]
        );
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