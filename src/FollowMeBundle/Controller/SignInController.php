<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormError;
use FollowMeBundle\Form\SignIn;
use FollowMeBundle\Entity\User;


class SignInController extends Controller
{
    
    /**
     * @Route("/signin", name="signin")
     */
    public function indexAction(Request $request)
    {
        try {
            $this->get("session")->start();
    
            if ($this->get("session")->get("id") ) {
                throw new \RuntimeException;
            }
            $form = $this->createForm(SignIn::class);
            $form->handleRequest($request);

            if  ( $form->isSubmitted() )
                if  ( $form->isValid() )
                    if ( $user = $this->getDoctrine()
                               ->getManager()
                               ->getRepository(User::class)
                               ->findOneBy(["userMail" => $form->getData()["user_mail"]])
                       )
                        {

                        if (!password_verify($form->getData()["user_pswd"], 
                            $user->getUserPswd()))
                            {
                                throw new \Throwable;                        
                            }                                    
                
                        $this->get("session")->set("id", $user->getUserId());
                        throw new \RuntimeException;                
                        }               
                    else
                        {
                            $form->addError(new FormError("Mail Inexistant"));
                            throw new \InvalidArgumentException;                
                        }
                else 
                    {
                        $form->addError(new FormError("form is not valid"));
                        throw new \InvalidArgumentException;                        
                    }         
            else
                {
                    $form->addError(new FormError("form is not submitted"));
                    throw new \InvalidArgumentException;                
                               }           
            throw new \InvalidArgumentException;

            } catch (\InvalidArgumentException $e) {
                
                
            } catch (\RuntimeException $e) {
                return $this->redirectToRoute("main");
                
            } catch (\Throwable $e) {
                
                $form->addError(new FormError("Mauvais Identifiants"));
            }
                       
        return $this->render('FollowMeBundle:SignIn:index.html.twig', 
                            ["form" => $form->createView()] );
    }
 
}
