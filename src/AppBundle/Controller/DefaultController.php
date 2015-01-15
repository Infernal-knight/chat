<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/ttt")
     * @Template("AppBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        $name = 'www';
        return array('name' => $name);
    }
}
