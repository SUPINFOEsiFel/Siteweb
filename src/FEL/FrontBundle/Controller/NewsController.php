<?php

namespace FEL\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class NewsController
 * @package FEL\FrontBundle\Controller
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="fel_front_news")
     * @Template()
     */
    public function indexAction()
    {
        $news = $this->getDoctrine()
            ->getRepository('FELAdminBundle:Article')
            ->findall();

        return array(
            "news" => $news
        );
    }

}
