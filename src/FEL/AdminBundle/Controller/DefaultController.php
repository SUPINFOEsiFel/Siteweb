<?php

namespace FEL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
