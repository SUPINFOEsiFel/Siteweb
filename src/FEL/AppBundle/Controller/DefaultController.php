<?php

namespace FEL\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package FEL\AppBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="fel_app_homepage")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $news = $this->getDoctrine()
            ->getRepository('FELAppBundle:Article')
            ->findall();

        return array('news' => $news);
    }
}
