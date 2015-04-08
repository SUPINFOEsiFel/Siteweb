<?php

namespace FEL\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FELAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
