<?php

namespace FEL\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

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
        /*$user = "lol";
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "main", array("ROLE_METEOR_ACCESS", "ROLE_NEWS_ACCESS"));
            $this->get("security.token_storage")->setToken($token); //now the user is logged in

            //now dispatch the login event
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }*/
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

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        );
    }

    /**
     * @Route("/login_check", name="fel_admin_check")
     * @Template()
     */
    public function checkAction()
    {
        $user = "dev";
        //TODO: REST meteor

        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "main", array("ROLE_METEOR_ACCESS"/*, "ROLE_NEWS_ACCESS"*/));
            //TODO: LIST ROLES

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
