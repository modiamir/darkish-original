<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Classified;
use Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree;
use Darkish\CategoryBundle\Entity\OfferOfferTree;
use Darkish\WebsiteBundle\Form\ClassifiedClassifiedTreeType;
use Darkish\WebsiteBundle\Form\ClassifiedType;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="%domain%")
 */
class ClassifiedController extends Controller
{
    /**
     * @Route("classified", name="website_classified", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');

        $qb = $repo->createQueryBuilder('c');

        $treeRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ClassifiedTree');
        $upTrees = $treeRepo->findBy(['upTreeIndex'=>'00']);

        $subTrees = $treeRepo->createQueryBuilder('ct')
            ->where('ct.upTreeIndex != :zero')
            ->setParameter('zero', "00")
            ->getQuery()
            ->getResult()
        ;

        $classifiedTree = null;
        if($request->query->has('tree'))
        {
            $classifiedTree = $treeRepo->findOneBy(['treeIndex' => $request->query->get('tree')]);
            $qb->join('c.classifiedtrees', 'ct', 'WITH');
            $qb->join('ct.tree', 'ctt', 'WITH', 'ctt.treeIndex = :tree')->setParameter('tree', $request->query->get('tree'));

        }
        $qb->orderBy('c.id', 'Desc');
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $qb->getQuery(),
            (int)$request->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('@DarkishWebsite/Classified/index.html.twig', array(
            'paginator' => $paginator,
            'upTrees' => $upTrees,
            'subTrees' => $subTrees,
            'classifiedTree' => $classifiedTree
        ));
    }

    /**
     * @param Request $request
     * @Route("classified/create", name="website_classified_submit")
     * @Method({"POST", "GET"})
     */
    public function submitClassifiedAction(Request $request) {
        $classified = new Classified();
        $classifiedClassifiedTree  = new ClassifiedClassifiedTree();
        $classified->addClassifiedtree($classifiedClassifiedTree);

        $form =$this->createForm(new ClassifiedType(), $classified);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $imagesIterators = $classified->getImages()->getIterator();
            while($imagesIterators->valid()) {
                $photo = $imagesIterators->current();
                /* @var $photo \Darkish\CategoryBundle\Entity\ManagedFile */
                $photo->setUploadDir('image');
                $photo->setType('comment');
                $photo->setUserId(0);
                $photo->upload();
                $photo->setStatus(false);
                $photo->setTimestamp(new \DateTime());
                $imagesIterators->next();
            }
//            $classified->setCreated(new \DateTime);
            $classified->setCreationDate(new \DateTime());
            $classified->setLastUpdate(new \DateTime());
            $classified->setHtmlLastUpdate(new \DateTime());
            $classified->setActive(true);
            $classified->setVerify(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($classified);
            $em->flush();
//            return new Response($this->get('jms_serializer')->serialize($classified, 'json', SerializationContext::create()->setGroups(["classified.details"])));
            return $this->redirect('');
        }

        return $this->render('DarkishWebsiteBundle:Classified:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Classified $classified
     * @Route("classified/{classified}", name="website_classified_single")
     */
    public function classifiedSingleAction(Classified $classified)
    {

        return $this->render('DarkishWebsiteBundle:Classified:classified.html.twig', [
            'classified' => $classified
        ]);
    }

}
