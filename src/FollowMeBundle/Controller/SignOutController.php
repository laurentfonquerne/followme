<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SignOutController extends Controller
{
    /**
     * @Route("/signout", name="signout")
     */
    public function indexAction()
    {
     try {
            $this->get("session")->start();

            if ($this->get("session")->get("id") ) {
                $this->get("session")->invalidate();
                throw new \RuntimeException;
            }   
                       
        } catch (\RuntimeException $e) {
            return $this->redirectToRoute("main");
            
        } catch (\Throwable $e) {
            $form->addError(new FormError("User Existant"));
        }
                   
    return $this->render('FollowMeBundle:SignUp:index.html.twig', 
    ["form" => $form->createView()]

    );
        return $this->render('FollowMeBundle:SignOut:index.html.twig', array(
            // ...
        ));
    }

}
