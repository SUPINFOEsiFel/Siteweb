<?php

namespace FEL\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package FEL\FrontBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="fel_front_homepage")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        return array();
    }
}
