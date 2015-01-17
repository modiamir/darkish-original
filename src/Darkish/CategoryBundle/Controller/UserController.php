<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\RecordLock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\MainTree;
use Darkish\CategoryBundle\Form\NewsType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\SerializationContext;
use Darkish\CategoryBundle\Form\RecordType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class UserController extends Controller
{
    public function logoutAction() {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $user = $this->get('security.context')->getToken();
        $serializer = $this->get('jms_serializer');
        return new Response('You logged out successfully');
    }

    public function isLoggedInAction() {
        $securityContext = $this->container->get('security.context');
        /* @var $securityContext \Symfony\Component\Security\Core\SecurityContext */
        $res = $securityContext->getToken()->isAuthenticated();
        

//        return new JsonResponse(array(
//                $this->get('security.context')->getToken()->getUser()->getRolesNames()
//        ));
        
        
        return new JsonResponse(array(
                $this->get('security.context')->isGranted(
                    'ROLE_USER'
                   ))
        );
    }
    
    public function loginAction(Request $request) {
        try{
            $em = $this->getDoctrine();
            $repo = $em->getRepository("DarkishUserBundle:Operator"); //Entity Repository
            $username = ($request->request->has('username'))? $request->request->get('username') : NULL;
            $password = ($request->request->has('password'))? $request->request->get('password') : NULL;
            if(!$username || !$password) {
                throw new Exception('Username or Password is missing!', 404);
            }
            $users = $repo->findByUsername($username);
            if (count($users) == 0) {
                throw new UsernameNotFoundException("User not found", 404);
            } else {
                $user = $users[0];
                $token = new UsernamePasswordToken($user, null, "admin_area", $user->getRoles());
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                /* @var $factory \Symfony\Component\Security\Core\Encoder\EncoderFactory */
                $isPassValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
                if(!$isPassValid) {
                    throw new Exception('Password is wrong!', 404);
                }
                $this->get("security.context")->setToken($token); //now the user is logged in
                
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                return new Response('logged in');
            }
        } catch(\Exception $ex) {
            return new Response($ex->getMessage(), 404);
        }
        
        
    }
}
