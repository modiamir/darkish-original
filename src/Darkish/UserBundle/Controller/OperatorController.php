<?php

namespace Darkish\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
class OperatorController extends Controller
{
    /**
     * @Route("/admin/operator/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render(
                    ':security:login.html.php', array(
                    // last username entered by the user
                    'last_username' => $lastUsername,
                    'error' => $error,
                        )
        );
    }

    /**
     * @Route("/admin/is_remembered", name="security_remembered")
     */
    public function isRememberedAction() {
        /* @var $sc \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken */
        $sc = $this->get('security.context')->getToken();
        
        
        return new JsonResponse($this->get('security.context')->isGranted(
        'IS_AUTHENTICATED_REMEMBERED'
       ));
    }
    
    /**
     * @Route("/admin/operator/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * @Route("/admin/operator/logout", name="logout")
     */
    public function logoutAction()
    {
    }
    
    /**
     * @Route("/admin/operator/check_permission", name="check_permission")
     */
    public function checkPermissionAction() {
        $record = new \Darkish\CategoryBundle\Entity\Record();
        return new JsonResponse($this->get('security.context')->isGranted('edit', $record));
        
        
    }
}
