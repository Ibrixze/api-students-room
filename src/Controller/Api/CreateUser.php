<?php 

namespace App\Controller\Api;

use App\Entity\User;
use App\Manager\UserManager;


class CreateUser{

    private $userManager;


    public function __construct(UserManager $userManager){
       $this -> userManager = $userManager;
    }

    public function __invoke(User $data){
        //dd($this -> userManager);
        return $this -> userManager -> RegisterUser($data);
    }

}