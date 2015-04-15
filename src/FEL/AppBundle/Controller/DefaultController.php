<?php

namespace FEL\AppBundle\Controller;

use FEL\AppBundle\Entity\Article;
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
    public function ajouterAction()
    {
        $message='';
        $article= new Article();

        $form = $this->container->get('form.factory')->ceate(new JuifForm(),$article);

        $request = $this->container->get('request');

        if ($request->getMethod()=='POST')
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getEntitManager();
                $em = persist($article);
                $em = flush();
                $message = 'Article posté';
            }
        }
        return $this->container->get('templating')->renderResponse(
            'EBOLA',
            array(
                'form'=> $form->createView(),
                'message'=> $message,
            )
        );
    }

}
