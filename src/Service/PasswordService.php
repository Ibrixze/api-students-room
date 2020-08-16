<?php 

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordService{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
        $this -> userPasswordEncoder = $userPasswordEncoder;
    }


    public function encode(object $entity, string $password) : string{
        return $this -> userPasswordEncoder -> encodePassword($entity, $password);
    }

    public function formatRequirement(string $password){
        return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*W\)#', $password);
    }

    public function isValid(object $entity, string $password):bool{
        return $this -> userPasswordEncoder -> isPasswordValid($entity, $password);
    }
 }