<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTEncodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\EncodedEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener{
    /**
     * @var RequestStack
     */
    private $requestStack;
    
    /**
     * 
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack){
        $this -> requestStack = $requestStack;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */

     public function onAuthenticatedSuccessResponse(AuthenticationSuccessEvent $event){
         $data = $event -> getData();
         $user = $event -> getUser();

         if(!$user instanceof UserInterface){
             return;
         }
         if($user instanceof User){
            $data["data"] = array(
                "id" => $user-> getId(),
                "nom" => $user-> getNom(),
                "prenoms" => $user-> getPrenoms(),
                "email" => $user-> getEmail(),
                "roles" => $user -> getRoles()
            );

            $event -> setData($data);

         }
     }  
}