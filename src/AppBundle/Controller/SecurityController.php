<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Profile;
use AppBundle\Form\UserRegisterType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends BaseController
{

    public function loginAction(Request $request)
    {

        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            return $this->redirect($this->generateUrl('app_map_index'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        $flag = true;
        if ($request->isMethod('POST')) {
            //return $this->redirectUrl('app_map_index');

            $_username = $request->get('_username');
            $_password = $request->get('_password');

            $user = $this->getDoctrine()->getManager()->getRepository(User::class)
                ->loadUserByUsername($_username);

            if(!$user){
                $flag = false;
                $this->flashError('Info: usuario no encontrado.');
            }

            if($user){
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $salt = $user->getSalt();
                if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
                    $flag = false;
                    $this->flashError('Info: password no correcto.');
                }
            }


            if($flag){
                //todo correcto
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);

                // If the firewall name is not main, then the set value would be instead:
                // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
                $this->get('session')->set('_security_main', serialize($token));

                // Fire the login event manually
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

                $user = $this->getUser();

                if($user){
                    return $this->redirectUrl('app_map_index');
                }
            }

        }

        $response = $this->render(
            'AppBundle:Security:login.html.twig',
            [
                'last_username' => $lastUsername,// last username entered by the user
                'error' => $error,
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_HOUR);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
        throw new \Exception('Which means that this Exception will not be raised anytime soon …');
    }

    public function registerAction(Request $request)
    {

//        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
//        {
//            return $this->redirect($this->generateUrl('backend_default_index'));
//        }

        $entity = new User();
        $form = $this->createForm(UserRegisterType::class, $entity, ['attr' => ['class' => '']]);
        $form->handleRequest($request);

        $validator = $this->container->get('validator');
        $validator->validate($entity, null, ['registration']);

        $profile = $this->em()->getRepository(Profile::class)->findOneBySlug(Profile::GUEST);
        $entity->setProfile($profile);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->persist($entity);
            $this->flashSuccess('Cuenta creada, puedes iniciar sesión.');

            return $this->redirectToRoute('app_security_login');
        }

        $response = $this->render(
            'AppBundle:Security:register.html.twig',
            [
                'formEntity' => $form->createView(),
            ]
        );

        $response->setSharedMaxAge(self::MAX_AGE_YEAR);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;

    }

}

