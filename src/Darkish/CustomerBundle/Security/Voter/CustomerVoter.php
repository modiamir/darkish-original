<?php

namespace Darkish\CustomerBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const MESSAGE = 'message';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
            self::MESSAGE,
        ));
    }

    public function supportsClass($class)
    {
    	$supportedClasses = array();
        $supportedClasses[] = 'Darkish\CustomerBundle\Entity\Customer';

        foreach($supportedClasses as $supportedClass) {
        	if($supportedClass === $class || is_subclass_of($class, $supportedClass)) {
        		return true;
        	}
        }

        return false;
    }

    /**
     * @var \AppBundle\Entity\Post $post
     */
    public function vote(TokenInterface $token, $entity, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($entity))) {
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
            case self::EDIT:
                // we assume that our data object has a method getOwner() to
                // get the current owner user entity for this data object
                if ($user->getId() === $entity->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
