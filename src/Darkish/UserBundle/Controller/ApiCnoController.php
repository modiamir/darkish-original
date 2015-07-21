<?php

namespace Darkish\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * [
     *{
     *   "id": 1103,
     *   "title": "تست",
     *   "sub_title": "شسیشی",
     *   "publish_date": "2015-05-20T13:52:24+0430",
     *   "audio": false,
     *   "video": false,
     *   "newstrees": [
     *       {
     *           "tree": {
     *               "id": 184,
     *               "tree_index": "001702",
     *               "title": "فيلم و کليپ"
     *           },
     *           "sort": "60"
     *       }
     *   ],
     *   "images": [
     *       {
     *           "icon_absolute_path": "http://localhost/n-darkish/web/media/cache/icon_thumb/uploads/image/news-1432129959-27896.png",
     *           "file_name": "news-1432129959-27896.png"
     *       },
     *       {
     *           "icon_absolute_path": "http://localhost/n-darkish/web/media/cache/icon_thumb/uploads/image/news-1432129960-72078.png",
     *           "file_name": "news-1432129960-72078.png"
     *       },
     *       {
     *           "icon_absolute_path": "http://localhost/n-darkish/web/media/cache/icon_thumb/uploads/image/news-1432129961-92249.png",
     *           "file_name": "news-1432129961-92249.png"
     *       }
     *   ]
     *   }
     *]
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

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is get html api for 'News', 'Classified' and 'Offer' and 'Record' HTML",
     *  
     * )
     * @Get("get_entity/{type}/{id}/{mode}", requirements={
     *     "id": "\d+",
     *     "type":"news|record|offer|classified",
     *     "mode":"body|list|listbody"
     * })
     */
    public function getEntityAction($type, $id, $mode) {

        $data= array('type' => $type, 'id'=> $id, 'mode' => $mode);

        $collectionConstraint = new Assert\Collection(array(
            'type'          =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Choice(
                                            array(
                                                'choices' => array('offer', 'classified', 'news', 'record'),
                                                'message' => "The value must be one of ('offer', 'classified', 'news', 'record')"
                                            )
                                        )
                                ),
            'id'        =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Type(array('type' => 'numeric')),
                                    new Assert\Range(array('min'=> 1))
                                ),
            'mode'          =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Choice(
                                            array(
                                                'choices' => array('body', 'list', 'listbody'),
                                                'message' => "The value must be one of ('body', 'list', 'listbody')"
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

            case 'record':
                $entityClass = 'DarkishCategoryBundle:Record';
                break;
        }

        $qb = $this->getDoctrine()->getRepository($entityClass)->createQueryBuilder('cno');
        // $qb->select('cno.body');
        $qb->where('cno.id = :id')->setParameter('id', $id)->setMaxResults(1);

        $result = $qb->getQuery()->getResult();



        if(count($result) <= 0) {
            throw new \Exception("Entity doesn't exists", 404);
        }

        switch ($mode) {
            case 'body':
                $entity = $this->get('jms_serializer')->serialize(array('body' => $result[0]->getBody()), 'json');
                break;
            
            case 'list':
                $entity = $this->get('jms_serializer')->serialize($result[0],'json', SerializationContext::create()->setGroups(array('api.list')));
                break;
            
            case 'listbody':
                $entity = $this->get('jms_serializer')->serialize($result[0],'json', SerializationContext::create()->setGroups(array('api.list', 'api.body')));
                break;
            
            
        }

        return new Response($entity);
        
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is records updates service.",
     *  
     * )
     * @Get("get_records_updates/{lastUpdate}")
     */
    public function getRecordsUpdatesAction($lastUpdate) {

        $updates = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
                        ->createQueryBuilder('r')
                        ->where('r.lastUpdate > :lastUpdate')->setParameter('lastUpdate', $lastUpdate)
                        ->getQuery()->getResult();

        $deletes = $this->getDoctrine()->getRepository('DarkishCategoryBundle:DeletedRecords')
                        ->createQueryBuilder('dr')
                        ->where('dr.deletedAt > :lastUpdate')->setParameter('lastUpdate', $lastUpdate)
                        ->getQuery()->getResult();


        $result = [
            'updates' => $updates,
            'deletes' => $deletes
        ];

        return new  Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('api.list', 'api.body'))));



    }

}
