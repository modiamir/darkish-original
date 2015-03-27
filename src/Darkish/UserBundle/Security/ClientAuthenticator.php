<?php

namespace Darkish\UserBundle\Security;

use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

class ClientAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{    
    protected $userProvider;

    public function __construct(ClientUserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function createToken(Request $request, $providerKey)
    {
        // look for an apikey query parameter
        // $apiKey = $request->query->get('apikey');

        // or if you want to use an "apikey" header, then do something like this:
        $apiKey = $request->headers->get('apikey');
        if (!$apiKey) {
            $apiKey = null;
            // throw new BadCredentialsException('No API key found');

            // or to just skip api key authentication
            // return null;
        }
        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $apiKey = $token->getCredentials();
        if($apiKey) {
            $username = $this->userProvider->getUsernameForApiKey($apiKey);
            // die($username);
            if (!$username) {
                throw new AuthenticationException(
                    sprintf('API Key "%s" does not exist.', $apiKey)
                );
            }

            $user = $this->userProvider->loadUserByUsername($username);

            return new PreAuthenticatedToken(
                $user,
                $apiKey,
                $providerKey,
                $user->getRoles()
            );    
        } else {
            return new PreAuthenticatedToken(
                'anonymous',
                null,
                $providerKey,
                array('IS_AUTHENTICATED_ANONYMOUSLY')
            ); 
        }
        
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed.", 403);
    }
}