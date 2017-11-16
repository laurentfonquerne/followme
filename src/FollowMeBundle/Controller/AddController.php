<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormError;
use FollowMeBundle\Form\Add;
use FollowMeBundle\Entity\User;
use FollowMeBundle\Entity\Dating;

class AddController extends Controller
{
    /**
     * @Route("/add", name="add")
     */
    public function indexAction(Request $request)
    {
        var_dump (
            $this
            ->get("security.authorization_checker")
            ->isGranted("ROLE_ADMIN")
        );
        try {
            $this->get("session")->start(); 
            if (!$this->get("session")->get("id")) {
                throw new \RuntimeException; 
            } 

        $form = $this->createForm(Add::class);
        $form->handleRequest($request);

        $idsession = $this->get("session")->get("id");
        $user = $this->getDoctrine()
                        ->getManager()
                        ->getRepository(User::class)
                        ->find($idsession);
        
        
        $dating = $this->get("follow_me.dating");
        if (!$form->isSubmitted() && !$form->isValid()) {
            throw new \InvalidArgumentException;
        }
        //var_dump($form->getData()["dating_start"]->getTimestamp());
        //var_dump($form->getData()["dating_end"]->getTimestamp());
        var_dump(time());
    
         if ($form->isSubmitted() && $form->isValid()) {

             $dating->setUser($user); 

             $dating->setDatingTitle(
                 $form->getData()["dating_title"]           
             );

             $dating->setDatingDescription(
                 $form->getData()["dating_description"]
             );
             
             $dating->setDatingStart(
                 $form->getData()["dating_start"]->getTimestamp()
             );
             
             $dating->setDatingEnd(
                 $form->getData()["dating_start"]->getTimestamp() +
                 $form->getData()["dating_end"]->getTimestamp()   +
                 3600
             );

             if ($form->getData()["dating_start"]->getTimestamp() - time() < 0) {
                $form->get("dating_start")
                ->addError(new FormError("rendez-vous périmé"));
                throw new \InvalidArgumentException;
                
            }        
            
            if 
                ($form->getData()["dating_end"]->getTimestamp() === -3600) {
                    $form->get("dating_end")
                    ->addError(new FormError("durée invalide"));
                    throw new \InvalidArgumentException;
            }   

            $dating->setDatingLat(
                 $form->getData()["dating_lat"]
            );
            $dating->setDatingLng(
                $form->getData()["dating_lng"]
            );
            $dating->setDatingLinkHref(
                $form->getData()["dating_link_href"]
            );
            $dating->setDatingLinkTitle(
                $form->getData()["dating_link_title"]
            );

            $this->getDoctrine()->getManager()->persist($dating);
            $this->getDoctrine()->getManager()->flush();

            $this->get("session")->set("id", $user->getUserId());       // fermer la session
            throw new \RuntimeException;                    
        } 

        } catch (\InvalidArgumentException $e){
            //$form->addError(new FormError("Le rendez-vous est périmé..."));  
            //dump($e);
            
        } catch (\RuntimeException $e){
                //var_dump($e);
                //exit;
           return $this->redirectToRoute('main'); 

           //dump($e);
           exit;
        } catch (Throwable $e){
                
            $form->addError(new FormError("Le rendez-vous existe déjà..."));  
        }

    return $this->render('FollowMeBundle:Add:index.html.twig',
        [
            "form" => $form ->createView()
        ]
                );
    }
}

