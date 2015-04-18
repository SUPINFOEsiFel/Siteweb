<?php

namespace FEL\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class NewsController
 * @package FEL\AppBundle\Controller
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $news = $this->getDoctrine()
            ->getRepository('FELAppBundle:Article')
            ->findall();

        return array(
                "news" => $news
            );
    }

    /**
     * @Route("/admin")
     * @Template()
     */
    public function adminAction(){
        return array();
    }

    /**
     * @Route("/admin/set/{action}",
     *      requirements={"action" = "create|update|delete"})
     * @Template()
     * @Method({"POST"})
     */
    public function setAction($action)
    {
        return array(
                // ...
            );
    }

    /**
     * @Route("/admin/form/{action}",
     *      requirements={"action" = "create|update|delete"})
     * @Template()
     * @Method({"GET"})
     */
    public function formAction($action)
    {
        return array(
                // ...
            );
    }

}
