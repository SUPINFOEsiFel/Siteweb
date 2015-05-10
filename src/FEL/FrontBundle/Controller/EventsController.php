<?php

namespace FEL\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class EventsController
 * @package FEL\FrontBundle\Controller
 * @Route("/events")
 */
class EventsController extends Controller
{
    /**
     * @Route("/", name="fel_front_events")
     * @Template()
     */
    public function indexAction(){
        $events = $this->get('meteor.browser')->get('events/', array(), true);

        return array(
            'events' => $events
        );
    }
}
