<?php

namespace Darkish\CategoryBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const VERIFY = 'verify';
    const CREATE = 'create';
    const ACTIVATE = 'activate';
    const OTHER = 'other';
    const REMOVE = 'remove';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
            self::VERIFY,
            self::CREATE,
            self::ACTIVATE,
            self::OTHER,
            self::REMOVE
        ));

    }

    public function supportsClass($class)
    {
        $supportedClass = 'Darkish\CategoryBundle\Entity\Record';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
    * @var \Darkish\CategoryBundle\Entity\Record $record
    */
    public function vote(TokenInterface $token,  $record, array $attributes)
    {
//        return VoterInterface::ACCESS_GRANTED;
            // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($record))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
            'Only one attribute is allowed for VIEW or EDIT'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];
        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $user = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case self::VIEW:
                // the data object could have for example a method isPrivate()
                // which checks the Boolean attribute $private
                    return VoterInterface::ACCESS_GRANTED;

                break;

            case self::EDIT:
                // we assume that our data object has a method getOwner() to
                // get the current owner user entity for this data object
                
                
                
                $allowed_roles = array(
                    'ROLE_EDITOR',
                    'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN',
                );
                if(count(array_intersect($allowed_roles, $user->getRolesNames())) ||
                    ($record->getUser() && $user->getId() == $record->getUser()->getId())) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::REMOVE:
                // we assume that our data object has a method getOwner() to
                // get the current owner user entity for this data object
                
                
                
                $allowed_roles = array(
                    'ROLE_SUPER_ADMIN',
                );
                if(count(array_intersect($allowed_roles, $user->getRolesNames())) ) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;

            case self::VERIFY:
                
                $allowed_roles = array(
                    'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN',
                );
                if(count(array_intersect($allowed_roles, $user->getRolesNames()))) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::CREATE:
                $allowed_roles = array(
                    'ROLE_PUBLISHER',
                    'ROLE_EDITOR',
                    'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN',
                );
                
                if(count(array_intersect($allowed_roles, $user->getRolesNames()))) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::ACTIVATE:
                $allowed_roles = array(
                    'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN',
                );
                if(count(array_intersect($allowed_roles, $user->getRolesNames()))) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::OTHER:
                $allowed_roles = array(
                    'ROLE_SUPER_ADMIN',
                );
                if(count(array_intersect($allowed_roles, $user->getRolesNames()))) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
