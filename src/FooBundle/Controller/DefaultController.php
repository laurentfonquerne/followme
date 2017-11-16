<?php

namespace FooBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/foo")
     */
    public function indexAction()
    {
        return $this->render('FooBundle:Default:index.html.twig');
    }
}
