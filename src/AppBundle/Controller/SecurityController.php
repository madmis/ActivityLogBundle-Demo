<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/user/create", name="create_user")
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();

        if (!$em->getRepository(User::class)->findOneBy(['name' => 'admin'])) {
            $user = new User();
            $user->setName('admin');
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, 'admin');
            $user->setPassword($password);


            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "User with 'admin' login and password was created!"
            );
        } else {
            $this->addFlash(
                'notice',
                "User with 'admin' login now exists"
            );
        }

        return $this->render('security/create.html.twig');
    }
}