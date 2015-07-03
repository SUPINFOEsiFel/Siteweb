<?php

namespace FEL\AdminBundle\Controller;

use Buzz;
use FEL\AdminBundle\Security\User\MeteorUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class DefaultController
 * @package FEL\AdminBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="fel_admin_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/login", name="fel_admin_login")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error' => $error,
        );
    }

    /**
     * @Route("/login_check", name="fel_admin_check")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkAction(Request $request)
    {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $auth = $this->get('meteor.browser')->post(
            'login/',
            array('user' => $username, 'password' => $password),
            array(),
            true
        );

        if ($auth["status"] == "success") {
            $user = new MeteorUser($username, $auth["data"]["userId"], $auth["data"]["authToken"], null, $this->container->getParameter("special_users"));
        } else {
            $user = false;
        }

        if (!$user) {
            $request->attributes->set(Security::AUTHENTICATION_ERROR, "Bad credentials");
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, "Bad credentials");
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());

            $this->get("security.token_storage")->setToken($token);

            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

        return $this->redirect($this->generateUrl('fel_admin_homepage'));
    }

    /**
     * @Route("/logout", name="fel_admin_logout")
     * @Template()
     */
    public function logoutAction()
    {
        return array();
    }
}
