<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DatingControllerController extends Controller
{
    /**
     * @Route("indexAction")
     */
    public function indexAction()
    {
        return $this->render('FollowMeBundle:DatingController:index.html.twig', array(
            // ...
        ));
    }

}
