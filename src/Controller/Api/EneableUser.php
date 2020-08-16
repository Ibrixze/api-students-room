<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EneableUser{

    protected $em;

    public function __construct(EntityManagerInterface $em){
        $this -> em = $em;
    }

    public function __invoke(User $data){
        $data->setIsActive(true);
        $this -> em -> persist($data);
        $this -> em -> flush();
        return $data;
    }

}