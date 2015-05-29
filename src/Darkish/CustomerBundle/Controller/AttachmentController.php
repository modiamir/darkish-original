<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use Darkish\CommentBundle\Entity\RecordThread;
use Darkish\CommentBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;

class AttachmentController extends Controller
{

	
	/**
	 * @Route("/customer/ajax/attachment/get_record_details", defaults={"_format"="json"})
	 * @Method({"GET"})
	 */
	public function getRecordDetailsAction() {
		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		
		return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(array('record.details', 'file.details'))));
	}


	/**
	 * @Route("/customer/ajax/attachment/save") 
	 * @Method({"POST"})
	 */
	public function saveAttachmentHtml(Request $request) {

		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();
		$data = $request->request->all();
		$em = $this->getDoctrine()->getManager();

		if(isset($data['images'])) {

		    $currentImages = $record->getImages();
		    if($currentImages) {
		        $newImages = new ArrayCollection();
		        $eCollec = new ArrayCollection();
		        $neCollec = new ArrayCollection();
		        $rCollec = new ArrayCollection();
		        $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
		        foreach($data['images'] as $image) {
		            $newImages->add($rep->find($image['id']));
		        }

		        $newImagesIterator = $newImages->getIterator();
		        while($newImagesIterator->valid()) {
		            if($currentImages->contains($newImagesIterator->current())) {
		                $eCollec->add($newImagesIterator->current());
		            } else {
		                $neCollec->add($newImagesIterator->current());
		            }
		            $newImagesIterator->next();
		        }

		        $currentImagesIterator = $currentImages->getIterator();
		        while($currentImagesIterator->valid()) {
		            if(!$eCollec->contains($currentImagesIterator->current()) && !$neCollec->contains($currentImagesIterator->current())) {
		                $currentImages->removeElement($currentImagesIterator->current());
		            }
		            $currentImagesIterator->next();
		        }

		        $neCollecIterator = $neCollec->getIterator();
		        while($neCollecIterator->valid()) {
		            $currentImages->add($neCollecIterator->current());
		            $neCollecIterator->next();
		        }
		    }



		    //$record->setImages($data['images']);
		}

		if(isset($data['videos'])) {
            $currentVideos = $record->getVideos();
            if($currentVideos) {
                $newVideos = new ArrayCollection();
                $eCollec = new ArrayCollection();
                $neCollec = new ArrayCollection();
                $rCollec = new ArrayCollection();
                $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
                foreach($data['videos'] as $video) {
                    $newVideos->add($rep->find($video['id']));
                }

                $newVideosIterator = $newVideos->getIterator();
                while($newVideosIterator->valid()) {
                    if($currentVideos->contains($newVideosIterator->current())) {
                        $eCollec->add($newVideosIterator->current());
                    } else {
                        $neCollec->add($newVideosIterator->current());
                    }
                    $newVideosIterator->next();
                }

                $currentVideosIterator = $currentVideos->getIterator();
                while($currentVideosIterator->valid()) {
                    if(!$eCollec->contains($currentVideosIterator->current()) && !$neCollec->contains($currentVideosIterator->current())) {
                        $currentVideos->removeElement($currentVideosIterator->current());
                    }
                    $currentVideosIterator->next();
                }

                $neCollecIterator = $neCollec->getIterator();
                while($neCollecIterator->valid()) {
                    $currentVideos->add($neCollecIterator->current());
                    $neCollecIterator->next();
                }
            }

            //$record->setVideos($data['videos']);
        }


		$em->persist($record);
		$em->flush();

		return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(array('record.details', 'file.details'))));		
	}

}
