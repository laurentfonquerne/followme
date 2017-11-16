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
        ->where($criteria->expr()->gt("datingEnd", time() ))
        ->setMaxResults($maxResults)
        ->orderBy(["datingEnd" => Criteria::DESC]);
        
        if ($page){
            echo "oui";
            $criteria->setFirstResult(($page -1) * $maxResults);
        }

        $dating = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository(User::class)
        ->matching($criteria);

        if (!$user[0] && $page > 1) {
            return $this->redirectToRoute("dating");
        }
        
         return $this->render('FollowMeBundle:Dating:index.html.twig', [
            "user"   => $user,         
            "page"   => $page,
            "max"    => $maxResults                 
            ]);
              
    }
     /**
     * @Route("/time", name="time")
     */
    
    public function indexActiontime (Request $request)
    
    {
        //si entete
        $clientGmt = $request->headers->get("if-modified-since");

        $gmt = gmdate('D, d M Y H:i:s T', time());
        
        $diff = time() - (new \DateTime($clientGmt))->getTimeStamp();
        
        if ($diff < 5
        && $clientGmt) {
            var_dump($diff);
            $response = new Response();
            $response->setStatusCode(304);
        } else {
            $response = $this->render('FollowMeBundle:Dating:index.html.twig', array(
                // ...
           ));
           $response->setLastModified(new \DateTime());

        }
               
        $response->setPublic();
        return $response;
        
    }    
       
    
    
    /**
     * @Route("/etag", name="etag")
     */
    
    public function indexActionSave2 (Request $request)
    {
        $ETag = md5($request->getRequestUri());
// if-not-match === etag alors reponse vide
// sinon reponse avec un rendu
        
        if ('"'. $ETag.'"' === current($request->getETags())) {
            var_dump($ETag);
            var_dump(current($request->getETags()));
            
            $response = new Response();
            $response->setStatusCode(304);
        }
        else {
            $response = $this->render('FollowMeBundle:Dating:index.html.twig', array(
                // ...
            ));
            
        }
         
        $response->setEtag($ETag);
        $response->setPublic(); // make sure the response is public/cacheable
        
        //dump ($request-getETags());

        return $response;
    }
    /**
     * @Route("/psr6", name="psr6")
     */
    
    public function indexActionSave()
    
    {
        $pool = new FilesystemAdapter("", 0, __DIR__. "./../../../var/cache/pools");
        var_dump($pool);
        $item = $pool->getItem('followme.users.custom');
        $item->expiresAfter(3);

        if (!$item->isHit()) {
            
            $users = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(User::class)
            ->findAll();
            $item->set($users);
            $pool->save($item);
        }
        $users = $item->get();
        var_dump($users);
    
        /* $cachedCategories = $this->get('cache.app')->getItem('categories');
        
        if (!$cachedCategories->isHit()) {
            $categories = ... // fetch categories from the database
            $cachedCategories->set($categories);
            $this->get('cache.app')->save($cachedCategories);
        } else {
            $categories = $cachedCategories->get();
        } */

        return $this->render('FollowMeBundle:Dating:index.html.twig', array(
            // ...
        ));
    }

}
