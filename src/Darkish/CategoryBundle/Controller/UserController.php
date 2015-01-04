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
        

        return new JsonResponse(array($res));
    }
}
