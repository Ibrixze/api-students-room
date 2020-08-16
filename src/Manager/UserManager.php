<?php 


namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserManager{

    protected $passwordService;
    protected $entityManager;
    protected $userRepository;
    public function __construct(PasswordService $passwordService, EntityManagerInterface $entityManager, UserRepository $userRepository){

        $this -> passwordService = $passwordService;
        $this -> entityManager = $entityManager;
        $this -> userRepository = $userRepository;
    }

    public function findEmail(string $email){
       $user = $this -> userRepository -> findByEmail($email);
        if($user)
            return $user[0];
        else    
           return null;
    }

    public function RegisterUser(User $user){
        if($this -> findEmail($user -> getEmail())){
            $response = ["message" => "Cette adresse e-mail existe deja", "user"=>null];
            return $response;
        }
        $user -> setEmail($user->getEmail());
        //dd($user);
        $password = $this -> passwordService -> encode($user, $user->getPassword());
        $user -> setPassword($password);
        $this -> entityManager -> persist($user);
        $this -> entityManager -> flush();
        $response = ["message" => "Utilisateur ajouté avec succès", "user" => $user];
        //dd($response);
        return $response; 
    }

}