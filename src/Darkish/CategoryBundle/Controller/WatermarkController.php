<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\Record;
use FOS\RestBundle\Controller\Annotations\Route;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\Pagination\AbstractPagination;

class WatermarkController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('DarkishCategoryBundle:Watermark:index.html.php');
    }

    /**
     * @param $page
     * @return Response
     * @Route("get_records", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function getRecordsAction(Request $request) {
        $em    = $this->getDoctrine();
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $qb = $repo->createQueryBuilder('r');
        $qb->orderBy('r.lastUpdate', 'desc');
        $qb->where('r.id > 0');
        if($request->request->has('number'))
        {
            $qb->andWhere('r.recordNumber like :recordNumber')->setParameter('recordNumber', '%'.$request->get('number').'%');
        }

        if($request->request->has('title'))
        {
            $qb->andWhere('r.title like :title')->setParameter('title', '%'.$request->get('title').'%');
        }

        if($request->request->has('new') && $request->get('new'))
        {
            $qb->andWhere('r.isCheckedFiles != :isCheckedFiles')->setParameter('isCheckedFiles', true);
        }


        $query = $qb->getQuery();

        $paginator  = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $query,
            ($request->request->has('page')) ? $request->request->getInt('page') : 1,
            20/*limit per page*/
        );
        /* @var $pagination AbstractPagination */

        $result = [];
        $result['records'] = $pagination->getItems();
        $result['totalPages'] = ceil($pagination->getTotalItemCount()/$pagination->getItemNumberPerPage());
        $result['currentPage'] = $pagination->getCurrentPageNumber();






        return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(["record.list"])));

    }


    /**
     * @param Record $record
     * @Route("get_record/{record}")
     */
    public function getRecordAction(Record $record)
    {
        return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(["record.details"])));
    }


    /**
     * @param Request $request
     * @Route("update_images/{record}")
     * @Method({"POST"})
     */
    public function updateImagesAction(Record $record, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');

        if($request->request->has('images')) {
            $images = $request->get('images');
            foreach($images as $image)
            {
                $imageEntity = $repo->find($image['id']);
                if(isset($image['darkish_watermark']))
                {
                    if($image['darkish_watermark']=="true")
                    {
                        $imageEntity->setDarkishWatermark(true);
                    } elseif($image['darkish_watermark']=="false")
                    {
                        $imageEntity->setDarkishWatermark(false);
                    }
                }

                if(isset($image['island_watermark']))
                {
                    if($image['island_watermark']=="true")
                    {
                        $imageEntity->setIslandWatermark(true);
                    } elseif($image['island_watermark']=="false")
                    {
                        $imageEntity->setIslandWatermark(false);
                    }
                }


                if(isset($image['aruna_watermark']))
                {
                    if($image['aruna_watermark']=="true")
                    {
                        $imageEntity->setArunaWatermark(true);
                    } elseif($image['aruna_watermark']=="false")
                    {
                        $imageEntity->setArunaWatermark(false);
                    }
                }

                if(isset($image['checked']))
                {
                    if($image['checked']=="true")
                    {
                        $imageEntity->setChecked(true);
                    } elseif($image['checked']=="false")
                    {
                        $imageEntity->setChecked(false);
                    }
                }

                $em->persist($imageEntity);
            }
        }

        if($request->request->has('body_images')) {
            $bodyImages = $request->get('body_images');
            foreach($bodyImages as $bodyImage)
            {
                $bodyImageEntity = $repo->find($bodyImage['id']);
                if(isset($bodyImage['darkish_watermark']))
                {
                    if($bodyImage['darkish_watermark']=="true")
                    {
                        $bodyImageEntity->setDarkishWatermark(true);
                    } elseif($bodyImage['darkish_watermark']=="false")
                    {
                        $bodyImageEntity->setDarkishWatermark(false);
                    }
                }


                if(isset($bodyImage['island_watermark']))
                {
                    if($bodyImage['island_watermark']=="true")
                    {
                        $bodyImageEntity->setIslandWatermark(true);
                    } elseif($bodyImage['island_watermark']=="false")
                    {
                        $bodyImageEntity->setIslandWatermark(false);
                    }
                }


                if(isset($bodyImage['aruna_watermark']))
                {
                    if($bodyImage['aruna_watermark']=="true")
                    {
                        $bodyImageEntity->setArunaWatermark(true);
                    } elseif($bodyImage['aruna_watermark']=="false")
                    {
                        $bodyImageEntity->setArunaWatermark(false);
                    }
                }

                if(isset($bodyImage['checked']))
                {
                    if($bodyImage['checked']=="true")
                    {
                        $bodyImageEntity->setChecked(true);
                    } elseif($bodyImage['checked']=="false")
                    {
                        $bodyImageEntity->setChecked(false);
                    }
                }

                $em->persist($bodyImageEntity);
            }
        }

        $record->setIsCheckedFiles(true);
        $em->persist($record);
        $em->flush();

        return new JsonResponse(['done']);
    }
}
