<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CompetenceVoter extends Voter
{

    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Permet de vérifie le rôle du USER
     * @param $role
     * @return bool
     */
    public function verifiyIsGranted ($role){
        return $this->security->isGranted($role);
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
       // dd($attribute, $subject);
        return in_array($attribute, ['GET_COMPETENCE', 'DELETE_COMPETENCE','PUT_COMPETENCE'])
            && $subject instanceof \App\Entity\Competence;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'GET_COMPETENCE':
                // on affiche la liste des competences
                return $user->getRoles()[0] === "ROLE_ADMIN" || $user->getRoles()[0] === "ROLE_FORMATEUR" || $user->getRoles()[0] === "ROLE_CM";
                break;
            case 'DELETE_COMPETENCE':
                // On supprime une competence
                 return  $user->getRoles()[0] === "ROLE_ADMIN" || $user->getRoles()[0] === "ROLE_FORMATEUR";
                break;
            case 'PUT_COMPETENCE':
                // On modifie une competence
                return  $user->getRoles()[0] === "ROLE_ADMIN" || $user->getRoles()[0] === "ROLE_FORMATEUR" || $user->getRoles()[0] === "ROLE_CM";
                break;
        }

        return false;
    }
}
