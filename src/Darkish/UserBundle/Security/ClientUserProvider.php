<?php

namespace Darkish\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Darkish\UserBundle\Entity\Client as Client;
use Doctrine\Common\Persistence\ObjectManager;


class ClientUserProvider implements UserProviderInterface
{

    protected $em;

	public function __construct(ObjectManager $em) 
	{
		$this->em = $em;
	}
    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $repo = $this->em->getRepository('Darkish\UserBundle\Entity\ApiToken');
        /* @var $repo \Doctrine\ORM\EntityRepository */
        $tokens = $repo->findBy(array('token' => $apiKey));
        if(count($tokens)) {
        	$token = $tokens[0];
        	$username = $token->getUsername();
        } else {
        	$token = null;
        	$username = null;
        }
        
        

        return $username;
    }

    public function loadUserByUsername($username)
    {
    	$repo = $this->em->getRepository('Darkish\UserBundle\Entity\Client');
    	$users = $repo->findBy(array('username' => $username));
    	$user = $users[0];
    	return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'Darkish\UserBundle\Entity\Client' === $class;
    }
}