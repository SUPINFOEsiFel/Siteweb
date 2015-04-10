<?php

namespace FEL\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $news = $em->getRepository('FELAppBundle:Article')->findall();


        return $this->container->get('templating')->renderResponse('FELAppBundle:Default:index.html.twig',
            array(
                'news' => $news
            ));
    }
}
