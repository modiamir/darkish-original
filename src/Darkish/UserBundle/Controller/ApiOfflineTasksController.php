<?php

namespace Darkish\UserBundle\Controller;

use Darkish\CategoryBundle\Entity\ClientItinerary;
use Darkish\UserBundle\Form\TasksType;
use Darkish\UserBundle\Form\TaskType;
use Darkish\UserBundle\Model\Task;
use Darkish\UserBundle\Model\Tasks;
use Darkish\WebsiteBundle\Form\ItineraryType;
use MyProject\Proxies\__CG__\stdClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;
use Darkish\CategoryBundle\Entity\Itinerary;
use FOS\RestBundle\Controller\Annotations as RouteAnnot;



/**
 * 
 */
class ApiOfflineTasksController extends FOSRestController
{

    /**
     * @RouteAnnot\Post("/handle", defaults={"_format"="json"})
     * @View()
     */
    public function handleTasksAction(Request $request)
    {
        $tasks = new Tasks();
        $form = $this->createForm(new TasksType(), $tasks);

        $form->handleRequest($request);

        if($form->isValid())
        {

            return $this->get('darkish.offline_tasks')->handleTasks($tasks->getTasks());
        }


        return $form->getErrorsAsString();

    }



}
