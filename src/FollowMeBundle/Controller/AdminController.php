<?php

namespace FollowMeBundle\Controller;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FollowMeBundle\Entity\User;
use FollowMeBundle\Entity\Dating;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
   
    public function indexAction (Request $request)
    
    {
        $id = (int) $request->get("e");

        $page = (int) $request->get("page") > 1
              ? (int) $request->get("page")
              : 1;

        $maxResults = 5;

        $this->get("session")->start(); 
        if (!$this->get("session")->get("id")) {
            return $this->redirectToRoute("main");
        }    
        $criteria = new Criteria();
        $criteria
        ->where($criteria->expr()->gt("userId", 1  ))
        ->setMaxResults($maxResults)
        ->orderBy(["userId" => Criteria::ASC]);
        
        if ($page){
            echo "oui";
            $criteria->setFirstResult(($page -1) * $maxResults);
        }

        $users = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository(User::class)
        ->matching($criteria);

        if (!$users[0] && $page > 1) {
            return $this->redirectToRoute("admin");
        }
        dump($id);








        
         return $this->render('FollowMeBundle:Admin:index.html.twig', [
            "users"   => $users,         
            "page"   => $page,
            "max"    => $maxResults,
            "id"     => $id                 
            ]);
              
    }
    /**
     * @Route("/admin/user/{id}", name="admin_user")
     */
   
    public function removeUserAction ($id)
    
    {
        $url=$this->generateUrl("admin");
        try {
            if (!($user = $this
            ->getDoctrine()
            ->getManager()
            ->find(User::class, $id))) {
                throw new \Throwable;
            }
            if (($dating = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Dating::class)
            ->findBy(["user" => $user]))
            && 0 !== count($dating)) {
                foreach ($dating as $date) {
                    $this->getDoctrine()->getManager()->remove($date);
                }
                $this->getDoctrine()->getManager()->flush();
            }
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($url . "?e=" . $id);
            
        } catch (\Throwable $e) {
            return $this->redirect($url . "?e");
        }    
    }
    
}
