<?php

namespace FEL\AdminBundle\Controller;

use Buzz;
use FEL\AdminBundle\Security\User\MeteorUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;
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
        //TODO: review authentication failure message
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
    public function checkAction(Request $request)
    {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        //TODO: cover exception as authentication failure
        $browser = new Buzz\Browser();
        $url = "http".(($this->container->getParameter(
                'meteor_secure'
            )) ? 's' : '')."://".$this->container->getParameter('meteor_host').":".(($this->container->getParameter(
                    'meteor_port'
                ) == null) ? "3000" : $this->container->getParameter('meteor_port'))."/api/";
        $response = null;

        try{
            $response = $browser->post($url.'login/', array(), '&user='.$username.'&password='.$password);
        } catch (Buzz\Exception\RequestException $e) {
            throw new ServiceUnavailableHttpException(null, "Meteor Service Unavailable, cannot reach the server.");
        }

        $auth = json_decode($response->getContent(), true);

        if ($auth["status"] == "success") {
            $user = new MeteorUser($username, $auth["data"]["userId"], $auth["data"]["authToken"]);
        } else {
            $user = false;
        }

        if (!$user) {
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
