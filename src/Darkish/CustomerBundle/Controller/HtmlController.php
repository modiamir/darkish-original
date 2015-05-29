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

class HtmlController extends Controller
{

	
	/**
	 * @Route("/customer/ajax/html/get_record_details", defaults={"_format"="json"})
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
	 * @Route("/customer/ajax/html/save") 
	 * @Method({"POST"})
	 */
	public function saveRecordHtml(Request $request) {

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
		$record->setBody($data['body']);

		if(isset($data['body_images'])) {

		    $currentBodyImages = $record->getBodyImages();
		    if($currentBodyImages) {
		        $newBodyImages = new ArrayCollection();
		        $eCollec = new ArrayCollection();
		        $neCollec = new ArrayCollection();
		        $rCollec = new ArrayCollection();
		        $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
		        foreach($data['body_images'] as $bodyimage) {
		            $newBodyImages->add($rep->find($bodyimage['id']));
		        }

		        $newBodyImagesIterator = $newBodyImages->getIterator();
		        while($newBodyImagesIterator->valid()) {
		            if($currentBodyImages->contains($newBodyImagesIterator->current())) {
		                $eCollec->add($newBodyImagesIterator->current());
		            } else {
		                $neCollec->add($newBodyImagesIterator->current());
		            }
		            $newBodyImagesIterator->next();
		        }

		        $currentBodyImagesIterator = $currentBodyImages->getIterator();
		        while($currentBodyImagesIterator->valid()) {
		            if(!$eCollec->contains($currentBodyImagesIterator->current()) && !$neCollec->contains($currentBodyImagesIterator->current())) {
		                $currentBodyImages->removeElement($currentBodyImagesIterator->current());
		            }
		            $currentBodyImagesIterator->next();
		        }

		        $neCollecIterator = $neCollec->getIterator();
		        while($neCollecIterator->valid()) {
		            $currentBodyImages->add($neCollecIterator->current());
		            $neCollecIterator->next();
		        }
		    }



		    //$record->setImages($data['images']);
		}


		if(isset($data['body_videos'])) {

		    $currentBodyVideos = $record->getBodyVideos();
		    if($currentBodyVideos) {
		        $newBodyVideos = new ArrayCollection();
		        $eCollec = new ArrayCollection();
		        $neCollec = new ArrayCollection();
		        $rCollec = new ArrayCollection();
		        $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
		        foreach($data['body_videos'] as $bodyvideo) {
		            $newBodyVideos->add($rep->find($bodyvideo['id']));
		        }

		        $newBodyVideosIterator = $newBodyVideos->getIterator();
		        while($newBodyVideosIterator->valid()) {
		            if($currentBodyVideos->contains($newBodyVideosIterator->current())) {
		                $eCollec->add($newBodyVideosIterator->current());
		            } else {
		                $neCollec->add($newBodyVideosIterator->current());
		            }
		            $newBodyVideosIterator->next();
		        }

		        $currentBodyVideosIterator = $currentBodyVideos->getIterator();
		        while($currentBodyVideosIterator->valid()) {
		            if(!$eCollec->contains($currentBodyVideosIterator->current()) && !$neCollec->contains($currentBodyVideosIterator->current())) {
		                $currentBodyVideos->removeElement($currentBodyVideosIterator->current());
		            }
		            $currentBodyVideosIterator->next();
		        }

		        $neCollecIterator = $neCollec->getIterator();
		        while($neCollecIterator->valid()) {
		            $currentBodyVideos->add($neCollecIterator->current());
		            $neCollecIterator->next();
		        }
		    }



		    //$record->setImages($data['images']);
		}


		if(isset($data['body_audios'])) {

		    $currentBodyAudios = $record->getBodyAudios();
		    if($currentBodyAudios) {
		        $newBodyAudios = new ArrayCollection();
		        $eCollec = new ArrayCollection();
		        $neCollec = new ArrayCollection();
		        $rCollec = new ArrayCollection();
		        $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
		        foreach($data['body_audios'] as $bodyaudio) {
		            $newBodyAudios->add($rep->find($bodyaudio['id']));
		        }

		        $newBodyAudiosIterator = $newBodyAudios->getIterator();
		        while($newBodyAudiosIterator->valid()) {
		            if($currentBodyAudios->contains($newBodyAudiosIterator->current())) {
		                $eCollec->add($newBodyAudiosIterator->current());
		            } else {
		                $neCollec->add($newBodyAudiosIterator->current());
		            }
		            $newBodyAudiosIterator->next();
		        }

		        $currentBodyAudiosIterator = $currentBodyAudios->getIterator();
		        while($currentBodyAudiosIterator->valid()) {
		            if(!$eCollec->contains($currentBodyAudiosIterator->current()) && !$neCollec->contains($currentBodyAudiosIterator->current())) {
		                $currentBodyAudios->removeElement($currentBodyAudiosIterator->current());
		            }
		            $currentBodyAudiosIterator->next();
		        }

		        $neCollecIterator = $neCollec->getIterator();
		        while($neCollecIterator->valid()) {
		            $currentBodyAudios->add($neCollecIterator->current());
		            $neCollecIterator->next();
		        }
		    }



		    //$record->setImages($data['images']);
		}
		
		if(isset($data['body_docs'])) {

		    $currentBodyDocs = $record->getBodyDocs();
		    if($currentBodyDocs) {
		        $newBodyDocs = new ArrayCollection();
		        $eCollec = new ArrayCollection();
		        $neCollec = new ArrayCollection();
		        $rCollec = new ArrayCollection();
		        $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
		        foreach($data['body_docs'] as $bodydoc) {
		            $newBodyDocs->add($rep->find($bodydoc['id']));
		        }

		        $newBodyDocsIterator = $newBodyDocs->getIterator();
		        while($newBodyDocsIterator->valid()) {
		            if($currentBodyDocs->contains($newBodyDocsIterator->current())) {
		                $eCollec->add($newBodyDocsIterator->current());
		            } else {
		                $neCollec->add($newBodyDocsIterator->current());
		            }
		            $newBodyDocsIterator->next();
		        }

		        $currentBodyDocsIterator = $currentBodyDocs->getIterator();
		        while($currentBodyDocsIterator->valid()) {
		            if(!$eCollec->contains($currentBodyDocsIterator->current()) && !$neCollec->contains($currentBodyDocsIterator->current())) {
		                $currentBodyDocs->removeElement($currentBodyDocsIterator->current());
		            }
		            $currentBodyDocsIterator->next();
		        }

		        $neCollecIterator = $neCollec->getIterator();
		        while($neCollecIterator->valid()) {
		            $currentBodyDocs->add($neCollecIterator->current());
		            $neCollecIterator->next();
		        }
		    }



		    //$record->setImages($data['images']);
		}


		$em->persist($record);
		$em->flush();

		return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(array('record.details', 'file.details'))));		
	}

}
