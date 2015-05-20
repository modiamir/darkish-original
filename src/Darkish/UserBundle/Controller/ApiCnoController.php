<?php

namespace Darkish\UserBundle\Controller;

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
use Darkish\CategoryBundle\Entity\MessageThread;
use Darkish\CategoryBundle\Entity\Message;
use Darkish\CustomerBundle\Entity\Customer;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * 
 */
class ApiCnoController extends FOSRestController
{
    /**
     * @Post("search")
     * @View(serializerGroups={"api.list"})
     * @ApiDoc(
     *  resource=true,
     *  description="This is search query api for retreiving 'News', 'Classified' and 'Offer'",
     *  parameters={
     *      {"name"="type", "dataType"="string", "required"=true, "description"="Type of entity and should be one of 'news'. 'offer' and 'classified'"},
     *      {"name"="treeindex", "dataType"="numeric string", "required"=true, "description"="The parent tree that you want to fetch its and its children's entities and should be like '00' or '0012' and so on."},
     *      {"name"="sort", "dataType"="string", "required"=true, "description"="The sort criteria. should be one of 'mostrecent' and 'mostvisited'"},
     *      {"name"="offset", "dataType"="numeric string", "required"=true, "description"="The offset of results"},
     *      {"name"="count", "dataType"="numeric string", "required"=true, "description"="The number of results"}
     *  }
     *  
     * )
     */
    public function searchAction (Request $request) {


        /**
         * Fetching data from request and convert data to array
         */
        $data = $request->request->getIterator()->getArrayCopy();


        // create a collection of constraints
        $collectionConstraint = new Assert\Collection(array(
            'type'          =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Choice(
                                            array(
                                                'choices' => array('offer', 'classified', 'news'),
                                                'message' => "The value must be one of ('offer', 'classified', 'news')"
                                            )
                                        )
                                ),
            'offset'        =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Type(array('type' => 'numeric')),
                                    new Assert\Range(array('min'=> 0))
                                ),
            'count'        =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Type(array('type' => 'numeric')),
                                    new Assert\Range(array('min'=> 0))
                                ),
            'treeindex'     =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Type(array('type' => 'numeric')),

                                ),
            'sort'          =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Choice(
                                            array(
                                                'choices' => array('mostrecent', 'mostvisited'),
                                                'message' => "The value must be one of ('mostrecent', 'mostvisited')"
                                            )
                                        )
                                )
        ));
    
        //validate data with created validation constraint
        $errorList = $this->get('validator')->validateValue($data, $collectionConstraint);


        //check if there is any error and send error as response
        if (count($errorList) != 0) {
            $errors = array();
            foreach ($errorList as $error) {
                // getPropertyPath returns form [email], so we strip it
                $field = substr($error->getPropertyPath(), 1, -1);

                $errors[$field] = $error->getMessage();
            }

            return array('success' => false, 'errors' => $errors);
        }
        
        

        switch ($data['type']) {
            case 'offer':
                $entityClass = 'DarkishCategoryBundle:Offer';
                break;

            case 'classified':
                $entityClass = 'DarkishCategoryBundle:Classified';
                break;

            case 'news':
                $entityClass = 'DarkishCategoryBundle:News';
                break;
        }

        $qb = $this->getDoctrine()->getRepository($entityClass)->createQueryBuilder('cno');

        switch ($data['type']) {
            case 'offer':
                $qb->join('cno.offertrees', 'cnotree');
                break;

            case 'classified':
                $qb->join('cno.classifiedtrees', 'cnotree');
                break;

            case 'news':
                $qb->join('cno.newstrees', 'cnotree');
                break;

        }

        $qb->join('cnotree.tree','t', 'WITH', $qb->expr()->like('t.treeIndex', $qb->expr()->literal($data['treeindex'].'%')));
        // $qb->join('cnotree.tree','t');
        // $qb->where($qb->expr()->like('t.treeIndex', $qb->expr()->literal($data['treeindex'].'%')));
        // $qb->where('t.treeIndex = :tindex')->setParameter('tindex', $data['treeindex']);
        

        switch ($data['sort']) {
            case 'mostvisited':
                $qb->orderBy('cno.visitCount', 'Desc');
                break;
            
            case 'mostrecent':
                $qb->addOrderBy('cno.publishDate', 'Desc');
                $qb->addOrderBy('cnotree.sort', 'Asc');
                break;
        }

        $qb->setMaxResults($data['count']);
        $qb->setFirstResult($data['offset']);

        return $qb->getQuery()->getResult();
        
    }


}
