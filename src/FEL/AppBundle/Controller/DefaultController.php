<?php

namespace FEL\AppBundle\Controller;

use FEL\AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FEL\AppBundle\Form\JuifForm;

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

    /**
     * @Route("/create", name="fel_app_create")
     * @Method({"POST"})
     * @Template()
     * @return array
     */
    public function ajouterAction($requestStack)
    {
        $message = '';
        $article = new Article();

        $form = $this->container->get('form.factory')->create(new JuifForm(),$article);

        $form->handleRequest($requestStack);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $message = 'Article posté';
        }

        return array(
                'form'=> $form->createView(),
                'message'=> $message,
            );
    }

}
