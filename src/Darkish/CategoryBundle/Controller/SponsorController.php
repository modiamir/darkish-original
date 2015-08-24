<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\SponsorLock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Darkish\CategoryBundle\Entity\Sponsor;
use Darkish\CategoryBundle\Entity\SponsorTree;
use Darkish\CategoryBundle\Entity\SponsorSponsorTree;
use Darkish\CategoryBundle\Form\SponsorType;
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


class SponsorController extends Controller
{
    private $numPerPage = 15;

    /**
     * Lists all Sponsor entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(!$user->routeAccess('sponsor')) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        $sponsor = new Sponsor();
//        if (false === $this->get('security.context')->isGranted('view', $sponsor)) {
//            throw new AccessDeniedException('Unauthorised access!');
//        }


        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:Sponsor')->findAll();




        return $this->render('DarkishCategoryBundle:Sponsor:index.html.php', array(
            'entities' => $entities,

        ));
    }

    public function updateAction(Request $request, $id) {
        
        
        try {
            $user = $this->getUser();
            $sponsor = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor')->find($id);
            
            if (false === $this->get('security.context')->isGranted('edit', $sponsor)) {
                throw new AccessDeniedException('Unauthorised access!');
            }
            
            $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
            $data = $serializer->deserialize($request->get('data'), 'array', 'json');
            /* @var $sponsor Sponsor*/
            
            
            $this->sponsorMassAssignment($sponsor, $data);
            $sponsor->setLastUpdate(new \DateTime());
            $sponsor->setHtmlLastUpdate(new \DateTime());
            $sponsor->setUser($user);
            
            if(!in_array('ROLE_ADMIN', $user->getRolesNames()) &&  !in_array('ROLE_SUPER_ADMIN', $user->getRolesNames())) {
                $sponsor->setVerify(false);
            }
            
            $validator = $this->get('validator');
            $errors = $validator->validate($sponsor);

            if (count($errors) ) {
                // perform some action, such as saving the task to the database
                /* @var $errors ConstraintViolationList */
                $error_iterator = $errors->getIterator();
                $error_msgs = array();
                while($error_iterator->valid()) {
                    /* @var $current_error ConstraintViolation */
                    $current_error = $error_iterator->current();
                    $error_msgs[] = $current_error->getMessage();
                    $error_iterator->next();
                }
                return new JsonResponse($error_msgs, 403);
            } else {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($sponsor);
                
                $em->flush();
                
                $this->setContinualThumbnailAction($data['images'], $data['body_images'], $data['videos'], $data['body_videos'], $data['audios'], $data['body_audios'], $data['body_docs']);
                
                return new Response($serializer->serialize($sponsor, 'json', SerializationContext::create()->setGroups(array('sponsor.details'))));

            };
        }catch (\Exception $e) {
            return new Response(
                $e->getLine().'<br/>'.
                $e->getMessage().'<br/>'.
                $e->getCode().'<br/>'.
                $e->getFile().'<br/>'.
                $e->getTraceAsString(), 401
            );
        }



    }


    public function createAction(Request $request) {
        try {
            $user = $this->getUser();
            $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
            $data = $serializer->deserialize($request->get('data'), 'array', 'json');
            /* @var $sponsor Sponsor*/
            $sponsor = new Sponsor();
            $this->sponsorMassAssignment($sponsor, $data);
            $sponsor->setCreationDate(new \DateTime());
            $sponsor->setLastUpdate(new \DateTime());
            $sponsor->setHtmlLastUpdate(new \DateTime());
            $sponsor->setUser($user);

            //return new Response($serializer->serialize($sponsor, 'json'));

            $validator = $this->get('validator');
            $errors = $validator->validate($sponsor);

            if (count($errors) ) {
                // perform some action, such as saving the task to the database

                /* @var $errors ConstraintViolationList */
                $error_iterator = $errors->getIterator();
                $error_msgs = array();
                while($error_iterator->valid()) {
                    /* @var $current_error ConstraintViolation */
                    $current_error = $error_iterator->current();
                    $error_msgs[] = $current_error->getMessage();
                    $error_iterator->next();
                }
                return new JsonResponse($error_msgs, 403);
            } else {

                $em = $this->getDoctrine()->getManager();
                $em->persist($sponsor);
                $em->flush();
                $data['images'] = (isset($data['images']))?$data['images']:[];
                $data['body_images'] = (isset($data['body_images']))?$data['body_images']:[];
                $data['videos'] = (isset($data['videos']))?$data['videos']:[];
                $data['body_videos'] = (isset($data['body_videos']))?$data['body_videos']:[];
                $data['audios'] = (isset($data['audios']))?$data['audios']:[];
                $data['body_audios'] = (isset($data['body_audios']))?$data['body_audios']:[];
                $data['body_docs'] = (isset($data['body_docs']))?$data['body_docs']:[];
                
                $this->setContinualThumbnailAction($data['images'], $data['body_images'], $data['videos'], $data['body_videos'], $data['audios'], $data['body_audios'], $data['body_docs']);
                
                

                return new Response($serializer->serialize(array($sponsor), 'json', SerializationContext::create()->setGroups(array('sponsor.details'))));

            };
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }



    }

    
    
    

    public function sponsorMassAssignment(Sponsor &$sponsor, $data) {

        if(isset($data['title'])) {
            $sponsor->setTitle($data['title']);
        }
        if(isset($data['sub_title'])) {
            $sponsor->setSubTitle($data['sub_title']);
        }

        if(isset($data['publish_date'])) {
            $date = new \DateTime($data['publish_date']);
            $sponsor->setPublishDate($date);
        }
        if(isset($data['expire_date'])) {
            $date = new \DateTime($data['expire_date']);
            $sponsor->setExpireDate($date);
        }
        
        if(isset($data['body'])) {
            $sponsor->setBody($data['body']);
        }

        if(isset($data['submitter_title'])) {
            $sponsor->setSubmitterTitle($data['submitter_title']);
        }

        if(isset($data['submitter_number'])) {
            $sponsor->setSubmitterNumber($data['submitter_number']);
        }

        if(isset($data['audio'])) {
            $sponsor->setAudio($data['audio']);
        }
        if(isset($data['video'])) {
            $sponsor->setVideo($data['video']);
        }
        
        if(isset($data['continual'])) {
            $sponsor->setContinual($data['continual']);
        }
        
        if(isset($data['immediate'])) {
            $sponsor->setImmediate($data['immediate']);
        }
        
        if(isset($data['list_rank'])) {
            $sponsor->setListRank($data['list_rank']);
        }
        
        
        
        if(isset($data['verify'])) {
            $sponsor->setVerify($data['verify']);
        } else {
            $sponsor->setVerify(false);
        }
        if(isset($data['active'])) {
            $sponsor->setActive($data['active']);
        } else {
            $sponsor->setActive(false);
        }
        
        if(isset($data['address'])) {
            $sponsor->setAddress($data['address']);
        }
        
        if(isset($data['tel_number_one'])) {
            $sponsor->setTelNumberOne($data['tel_number_one']);
        }
        if(isset($data['tel_number_two'])) {
            $sponsor->setTelNumberTwo($data['tel_number_two']);
        }
        if(isset($data['tel_number_three'])) {
            $sponsor->setTelNumberThree($data['tel_number_three']);
        }
        if(isset($data['tel_number_four'])) {
            $sponsor->setTelNumberFour($data['tel_number_four']);
        }
        if(isset($data['fax_number_one'])) {
            $sponsor->setFaxNumberOne($data['fax_number_one']);
        }
        if(isset($data['fax_number_two'])) {
            $sponsor->setFaxNumberTwo($data['fax_number_two']);
        }
        if(isset($data['mobile_number_one'])) {
            $sponsor->setMobileNumberOne($data['mobile_number_one']);
        }
        if(isset($data['mobile_number_two'])) {
            $sponsor->setMobileNumberTwo($data['mobile_number_two']);
        }
        if(isset($data['email'])) {
            $sponsor->setEmail($data['email']);
        }
        if(isset($data['website'])) {
            $sponsor->setWebsite($data['website']);
        }
        
        
        if(isset($data['icon'])) {
            $iconRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
            $em = $this->getDoctrine()->getManager();
            if(isset($data['icon']['id'])) {
                $icon = $iconRepo->find($data['icon']['id']);
                if($icon) {
                    $sponsor->setIcon($icon);
                    if(isset($data['icon']['continual']) && $data['icon']['continual']) {
                        $icon->setContinual(true);
                        $em->persist($icon);
                        $em->flush();
                    } else {
                        $icon->setContinual(false);
                        $em->persist($icon);
                        $em->flush();
                    }
                }
            } else {
                $sponsor->setIcon();
            }
            
        }
        if(isset($data['banner'])) {
            $bannerRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
            $em = $this->getDoctrine()->getManager();
            if(isset($data['banner']['id'])) {
                $banner = $bannerRepo->find($data['banner']['id']);
                if($banner) {
                    $sponsor->setBanner($banner);
                    if(isset($data['banner']['continual']) && $data['banner']['continual']) {
                        $banner->setContinual(true);
                        $em->persist($banner);
                        $em->flush();
                    } else {
                        $banner->setContinual(false);
                        $em->persist($banner);
                        $em->flush();
                    }
                }
            } else {
                $sponsor->setBanner();
            }
            
        }
        if(isset($data['vertical_banner'])) {
            $verticalBannerRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
            $em = $this->getDoctrine()->getManager();
            if(isset($data['vertical_banner']['id'])) {
                $verticalBanner = $verticalBannerRepo->find($data['vertical_banner']['id']);
                if($verticalBanner) {
                    $sponsor->setVerticalBanner($verticalBanner);
                    if(isset($data['vertical_banner']['continual']) && $data['vertical_banner']['continual']) {
                        $verticalBanner->setContinual(true);
                        $em->persist($verticalBanner);
                        $em->flush();
                    } else {
                        $verticalBanner->setContinual(false);
                        $em->persist($verticalBanner);
                        $em->flush();
                    }
                }
            } else {
                $sponsor->setVerticalBanner();
            }

        }
        if(false && isset($data['trees'])) {
            $currentTrees = $sponsor->getTrees();
            $newTrees = new ArrayCollection();
            $eCollec = new ArrayCollection();
            $neCollec = new ArrayCollection();
            $rCollec = new ArrayCollection();
            $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
            foreach($data['trees'] as $tree) {
                $newTrees->add($rep->find($tree['id']));
            }

            $newTreesIterator = $newTrees->getIterator();
            while($newTreesIterator->valid()) {
                if($currentTrees->contains($newTreesIterator->current())) {
                    $eCollec->add($newTreesIterator->current());
                } else {
                    $neCollec->add($newTreesIterator->current());
                }
                $newTreesIterator->next();
            }

            $currentTreesIterator = $currentTrees->getIterator();
            while($currentTreesIterator->valid()) {
                if(!$eCollec->contains($currentTreesIterator->current()) && !$neCollec->contains($currentTreesIterator->current())) {
                    $currentTrees->removeElement($currentTreesIterator->current());
                }
                $currentTreesIterator->next();
            }

            $neCollecIterator = $neCollec->getIterator();
            while($neCollecIterator->valid()) {
                $currentTrees->add($neCollecIterator->current());
                $neCollecIterator->next();
            }



            //$sponsor->setTrees($data['trees']);
        }

        if(isset($data['sponsortrees'])) {
            // die($this->get('jms_serializer')->serialize($data['sponsortrees'], 'json'));
            $currentMaintrees = $sponsor->getSponsortrees();
            if(!$currentMaintrees) {
                $currentMaintrees = new ArrayCollection();
            }
            $currentTrees = new ArrayCollection();
            $newTrees = new ArrayCollection();
            $eCollec = new ArrayCollection();
            $neCollec = new ArrayCollection();
            $rCollec = new ArrayCollection();

            $currentMaintreesIterator = $currentMaintrees->getIterator();
            while ($currentMaintreesIterator->valid()) {
                $cur = $currentMaintreesIterator->current();
                $currentTrees->add(array('tree'=> $cur->getTree(), 'sort' => $cur->getSort()));
                $currentMaintreesIterator->next();
            }

            
            $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
            foreach($data['sponsortrees'] as $tree) {
                $newTrees->add(array('tree' => $rep->find($tree['tree']['id']), 'sort' => $tree['sort'] ));
            }   


            $newTreesIterator = $newTrees->getIterator();
            while($newTreesIterator->valid()) {
                $cur = $newTreesIterator->current();
                if($currentTrees->contains($cur)) {
                    $eCollec->add($cur);
                } else {
                    $neCollec->add($cur);
                }
                $newTreesIterator->next();
            }

            $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorSponsorTree');
            $em = $this->getDoctrine()->getManager();
            
            $currentTreesIterator = $currentTrees->getIterator();
            while($currentTreesIterator->valid()) {
                if(!$eCollec->contains($currentTreesIterator->current()) && !$neCollec->contains($currentTreesIterator->current())) {
                    $cur = $currentTreesIterator->current();
                    $tmp = $rep->findBy(array('sponsor'=>$sponsor->getId(), 'tree' => $cur['tree']->getId()));
                    $tmp = $tmp[0];
                    $em->remove($tmp);
                    // $currentTrees->removeElement($currentTreesIterator->current());
                }
                $currentTreesIterator->next();
            }
            
            $neCollecIterator = $neCollec->getIterator();
            while($neCollecIterator->valid()) {
                $cur = $neCollecIterator->current();
                $tmp = new SponsorSponsorTree();
                $tmp->setSponsor($sponsor);
                $tmp->setTree($cur['tree']);
                $tmp->setSort($cur['sort']);
                $em->persist($tmp);
                $neCollecIterator->next();
            }
            // $em->flush();



            //$sponsor->setTrees($data['trees']);
        }

        if(isset($data['images'])) {

            $currentImages = $sponsor->getImages();
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



            //$sponsor->setImages($data['images']);
        }
        if(isset($data['body_images'])) {

            $currentBodyImages = $sponsor->getBodyImages();
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



            //$sponsor->setImages($data['images']);
        }
        if(isset($data['videos'])) {
            $currentVideos = $sponsor->getVideos();
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

            //$sponsor->setVideos($data['videos']);
        }
        if(isset($data['body_videos'])) {

            $currentBodyVideos = $sponsor->getBodyVideos();
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



            //$sponsor->setImages($data['images']);
        }
        if(isset($data['audios'])) {

            $currentAudios = $sponsor->getAudios();
            if($currentAudios) {
                $newAudios = new ArrayCollection();
                $eCollec = new ArrayCollection();
                $neCollec = new ArrayCollection();
                $rCollec = new ArrayCollection();
                $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
                foreach($data['audios'] as $audio) {
                    $newAudios->add($rep->find($audio['id']));
                }

                $newAudiosIterator = $newAudios->getIterator();
                while($newAudiosIterator->valid()) {
                    if($currentAudios->contains($newAudiosIterator->current())) {
                        $eCollec->add($newAudiosIterator->current());
                    } else {
                        $neCollec->add($newAudiosIterator->current());
                    }
                    $newAudiosIterator->next();
                }

                $currentAudiosIterator = $currentAudios->getIterator();
                while($currentAudiosIterator->valid()) {
                    if(!$eCollec->contains($currentAudiosIterator->current()) && !$neCollec->contains($currentAudiosIterator->current())) {
                        $currentAudios->removeElement($currentAudiosIterator->current());
                    }
                    $currentAudiosIterator->next();
                }

                $neCollecIterator = $neCollec->getIterator();
                while($neCollecIterator->valid()) {
                    $currentAudios->add($neCollecIterator->current());
                    $neCollecIterator->next();
                }
            }

            //$sponsor->setAudios($data['audios']);
        }
        if(isset($data['body_audios'])) {

            $currentBodyAudios = $sponsor->getBodyAudios();
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



            //$sponsor->setImages($data['images']);
        }
        
        if(isset($data['body_docs'])) {

            $currentBodyDocs = $sponsor->getBodyDocs();
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



            //$sponsor->setImages($data['images']);
        }
    }
    
    
    private function setContinualThumbnailAction($images, $body_images, $videos, $body_videos, $audios, $body_audios, $body_docs) {
//        $serializer = $this->get('jms_serializer');
//            /* @var $serializer JMSSerializer */
//        $data = $serializer->deserialize($request->get('data'), 'array', 'json');
//        $images = $data['images'];
//        $videos = $data['videos'];
//        $audios = $data['audios'];
//        
//        $body_images = $data['body_images'];
//        $body_audios = $data['body_audios'];
//        $body_videos = $data['body_videos'];
        
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
        $em = $this->getDoctrine()->getManager();
        
        $files = array_merge($images, $audios, $videos, $body_audios, $body_images, $body_videos, $body_docs);
        
        
        /**
         * settings isThumbnail and continual for files
         */
        
        foreach($files as $key => $file) {
            /* @var $managedFile \Darkish\CategoryBundle\Entity\ManagedFile */
            $managedFile = $repo->find($file['id']);
            if(isset($file['is_thumbnail'])) {
                $managedFile->setIsThumbnail($file['is_thumbnail']);
            } else {
                $managedFile->setIsThumbnail(false);
            }
            if(isset($file['continual'])) {
                $managedFile->setContinual($file['continual']);
            } else {
                $managedFile->setContinual(false);
            }
            
            
            $em->persist($managedFile);
            
        }
        $em->flush();
//        return new Response('Operation done succesfully', 200);
        
    }

    public function getTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:SponsorTree');
        // $categories = $repository->findAll();
        $qb = $repository->createQueryBuilder('t');
        $qb->orderBy('t.upTreeIndex', 'Asc');
        $qb->addOrderBy('t.sort', 'Asc');
        $categories = $qb->getQuery()->getResult();
        
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product SponsorTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $node['parent_tree_title'] = $product->getParentTreeTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }

    public function containsTreeAction($sponsorId, $treeId) {
        try {
            /* @var $sponsor Sponsor */
            $sponsor =$this->getDoctrine()->getManager()->getRepository('DarkishCategoryBundle:Sponsor')->find($sponsorId);
            $trees = $sponsor->getTrees();
            $tempArray = new ArrayCollection();

            $iterator = $trees->getIterator();
            $counter = 0;
            $currents = array();
            while($iterator->valid()) {

                $counter++;

                $currents[] = $iterator->current();
                $iterator->next();
            }

            return new Response($this->get('jms_serializer')->
                serialize($currents, 'json', SerializationContext::create()->setGroups(array('sponsor.details'))));
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }


    public function getTreeLinearAction() {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:SponsorTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product SponsorTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $node['parent_tree_title'] = $product->getParentTreeTitle();
            $tree[$key] = $node;
        }

        return new Response(
            json_encode($tree),
            200
        );
    }



    private function buildTree(array $elements, $parentId = "00") {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['upTreeIndex'] === $parentId) {
                $children = $this->buildTree($elements, $element['treeIndex']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function getJsonAction() {
        $Sponsor = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:Sponsor')
            ->find(1);

        $Tree = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:SponsorTree')
            ->find(1);

        /* @var $serializer JMSSerializer */
        $serializer = $this->get('jms_serializer');

        /* @var $Sponsor Sponsor */
        $Sponsor->addTree($Tree);



        return new Response(
            $serializer->serialize($Tree, 'json', SerializationContext::create()->setGroups(array('list', 'Default')))
        );
    }

    public function getSponsorForCategoryAction($cid, $count) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$sponsorList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.verify= :verify')
                ->setParameter('verify', false)
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $sponsorList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($sponsorList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }

        if($cid == 0) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$sponsorList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('r');
            /* @var $queryBuilder QueryBuilder */
            $sponsorWithTree = $queryBuilder->select('r.id')->join('r.sponsortrees','rt')->join('rt.tree','t', 'WITH')->distinct();
            $qb2 = $repository->createQueryBuilder('rr');
            $sponsorWithoutTree = $qb2->where($queryBuilder->expr()->notIn('rr.id',$sponsorWithTree->getDQL()))
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage);
            $serialized = $this->get('jms_serializer')->
                serialize($sponsorWithoutTree->getQuery()->getResult(), 'json', SerializationContext::create()->setGroups(array('sponsor.list')));





            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$sponsorList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.active= :active')
                ->setParameter('active', false)
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $sponsorList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($sponsorList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }
        
        if($cid == -3) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$sponsorList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->orderBy('n.creationDate', 'Desc')
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $sponsorList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($sponsorList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }


        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:SponsorTree');
        /* @var $repository \Darkish\CategoryBundle\Entity\SponsorTreeRepository */
        $category =  $repository->find($cid);

        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category SponsorTree */
//            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
//            //$sponsorList = $repository->findBy(array('category' => $category->getTreeIndex()));
//
//            $queryBuilder = $repository->createQueryBuilder('n');
//            /* @var $queryBuilder QueryBuilder */
//            $queryBuilder->where('n.sponsortreeId = :ntid')
//                ->setParameter('ntid', $category->getId())
//                ->setFirstResult(($page-1) * $this->numPerPage)
//                ->setMaxResults($this->numPerPage)
//            ;
//
//
//            $query = $queryBuilder->getQuery();
//            $sponsorList =  $query->getResult();
            
            $children = $this->getTreeChildren($category);
            
            $treesIds = array();
            $treesIds[] = $category->getId();
            foreach($children as $child) {
                $treesIds[] = $child->getId();
            }
            
            /* @var $repository \Darkish\CategoryBundle\Entity\SponsorRepository */
            $repository = $this->getDoctrine()
                ->getRepository('DarkishCategoryBundle:Sponsor');
            $qb = $repository->createQueryBuilder('r');
            $qb->join('r.sponsortrees', 'rt');
            $qb->join('rt.tree','t', 'WITH',$qb->expr()->in('t.id', $treesIds))->distinct();
            $res = $qb->setFirstResult($count)
                ->setMaxResults($this->numPerPage)->getQuery()->getResult();
            
            $serialized = $this->get('jms_serializer')->
                serialize($res, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));




//            $sponsorList = $category->getSponsors();
//            $encoders = array(new XmlEncoder(), new JsonEncoder());
//            $normalizers = array(new GetSetMethodNormalizer());
//
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $serialized = $serializer->serialize($sponsorList, 'json');

            return new Response(
                $serialized
                , 200);
        }

    }
    
    private function getTreeChildren($category) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
        /* @var $repo \Darkish\CategoryBundle\Entity\MainTree  */
        $qb = $repo->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        $qb->where($qb->expr()->like('r.upTreeIndex', $qb->expr()->literal($category->getTreeIndex() . '%')));
        return $qb->getQuery()->getResult();
    }


    public function searchSponsorsAction($keyword, $search_by, $sort_by, $count = 0) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
        $qb = $repo->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        switch($search_by) {
            case '1':
                $qb->where($qb->expr()->like('r.title', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            case '3':
                $qb->orWhere($qb->expr()->like('r.title', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.subTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.body', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            default:

                break;
        }

        switch($sort_by) {
            case '2':
                $qb->orderBy('r.creationDate', 'Asc');
                break;
            default:
                $qb->orderBy('r.creationDate', 'Desc');
                break;
        }

        $qb->setFirstResult($count);
        $qb->setMaxResults($this->numPerPage);

        $res = $qb->getQuery()->getResult();

        return new Response($this->get('jms_serializer')->serialize($res, 'json', SerializationContext::create()->setGroups(array('sponsor.list'))));
    }

    

    public function getSponsorAction($id) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
        $sponsor = $repository->find($id);

        if(!$sponsor) {
            return new Response("Sponsor ID is invalid", 404);
        }
//        return new Response($this->get('jms_serializer')->serialize($sponsor, 'json'));
        return new Response($this->get('jms_serializer')->serialize($sponsor, 'json', SerializationContext::create()->setGroups(array('sponsor.details'))));
    }


    public function generateCsrfAction() {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken(''); //Intention should be empty string, if you did not define it in parameters
        return new Response($token);
    }

    public function verifySponsorAction($sponsorId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Sponsor');
        $sponsor = $repo->find($sponsorId);

        if(!$sponsor) {
            return new Response('sponsor_id is invalid!', 404);
        }
        /* @var $sponsor Sponsor */
        $sponsor->setVerify(true);
        $em->persist($sponsor);
        $em->flush();

        return new Response('Sponsor verified.');

    }


    public function toggleVerifySponsorAction($sponsorId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Sponsor');
        $sponsor = $repo->find($sponsorId);

        if(!$sponsor) {
            return new Response('sponsor_id is invalid!', 404);
        }
        /* @var $sponsor Sponsor */
        $sponsor->setVerify(!$sponsor->getVerify());
        $em->persist($sponsor);
        $em->flush();

        return new JsonResponse(array('verify' => $sponsor->getVerify()));

    }

    public function deleteSponsorAction($sponsorId) {
        try{
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DarkishCategoryBundle:Sponsor');
            $sponsor = $repo->find($sponsorId);
            /* @var $sponsor Sponsor */
            $em->remove($sponsor);
            $em->flush();
            return new Response('Sponsor deleted');
        } catch(\Doctrine\ORM\ORMInvalidArgumentException $e) {
            return new Response('Sponsor Not found', 404);
        }



    }


    public function getUsernameAction() {
        /* @var $sc \Symfony\Component\Security\Core\SecurityContext */
        $sc = $this->get('security.context');

        return new Response($sc->getToken()->getUsername());
    }

    public function toggleActiveSponsorAction($sponsorId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Sponsor');
        $sponsor = $repo->find($sponsorId);

        if(!$sponsor) {
            return new Response('sponsor_id is invalid!', 404);
        }
        /* @var $sponsor Sponsor */
        $sponsor->setActive(!$sponsor->getActive());
        $em->persist($sponsor);
        $em->flush();
        return new JsonResponse(array('active' => $sponsor->getActive()));

    }


    public function setMainSponsorAction(Sponsor $sponsor) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Sponsor');
        $mainSponsors = $repo->findBy(['mainSponsor' => true]);

        foreach ($mainSponsors as $key => $mainSponsor) {
            $mainSponsor->setMainSponsor(false);
            $em->persist($mainSponsor);
        }


        /* @var $sponsor Sponsor */
        $sponsor->setMainSponsor(true);
        $em->persist($sponsor);
        $em->flush();
        return new JsonResponse(array('active' => $sponsor->getActive()));

    }

    public function accessAction() {
        $sponsor = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor')->find(1);
        $voter = $this->get('security.context');

        return new JsonResponse($voter->isGranted('view', $sponsor));
    }

    
    
    public function checkPermissionAction($attribute, $id = null) {
        try {
            if($id) {
                $sponsor = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor')->find($id);
            }else {
                $sponsor = new Sponsor();
            }
            $granted = $this->get('security.context')->isGranted($attribute, $sponsor);
            return new JsonResponse(array($granted));
        } catch(Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
        
        return new JsonResponse(array($attribute,$class, $id));
    }
    
    public function getSponsorByIdAction($id) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            $sponsor = $repo->find($id);
            if($sponsor) {
                return new Response($this->get('jms_serializer')->serialize($sponsor, 'json', SerializationContext::create()->setGroups(array('sponsor.details'))));
            } else {
                return new Response('Not found', 404);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
            
    }
    
    public function getTreeByIndexAction($index) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
            $trees = $repo->findByTreeIndex($index);
            if(count($trees)) {
                $tree = $trees[0];
                return new Response($this->get('jms_serializer')->serialize($tree, 'json'));
            } else {
                return new Response('Not found', 404);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getTestTreeAction($id) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
        return new Response($this->get('jms_serializer')->serialize($repo->find($id), 'json'));
    }
    
    public function totalSearchSponsorsAction($keyword, $search_by, $sort_by) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
        $qb = $repo->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        $qb->select("count(r.id)");
        switch($search_by) {
            case '1':
                $qb->where($qb->expr()->like('r.title', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            case '2':
                $qb->where($qb->expr()->like('r.sponsorNumber', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            case '3':
                $qb->orWhere($qb->expr()->like('r.title', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.subTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.legalName', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.messageText', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.email', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.website', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.address', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.searchKeywords', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.body', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.englishTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.englishSubTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.arabicTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.arabicSubTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.turkishTitle', $qb->expr()->literal('%' . $keyword . '%')));
                $qb->orWhere($qb->expr()->like('r.turkishSubTitle', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            default:

                break;
        }

        switch($sort_by) {
            case '4':
                $qb->orderBy('r.sponsorNumber', 'Asc');
                break;
            case '3':
                $qb->orderBy('r.sponsorNumber', 'Desc');
                break;
            case '2':
                $qb->orderBy('r.creationDate', 'Asc');
                break;
            default:
                $qb->orderBy('r.creationDate', 'Desc');
                break;
        }

        $qb->setFirstResult(0);
        
        $res = $qb->getQuery()->getSingleScalarResult();

        return new Response($this->get('jms_serializer')->serialize($res, 'json', SerializationContext::create()->setGroups(array('sponsor.list'))));
    }
    
    
    public function getTotalSponsorForCategoryAction($cid) {
        

        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            
            $queryBuilder->select('count(n.id)');
            $queryBuilder->where('n.verify= :verify')
                ->setParameter('verify', false)
                ->setFirstResult(0)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getSingleScalarResult();



            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }

        if($cid == 0) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$newsList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('r');
            /* @var $queryBuilder QueryBuilder */
            $sponsorWithTree = $queryBuilder->select('r.id')->join('r.trees','t', 'WITH')->distinct();
            $qb2 = $repository->createQueryBuilder('rr');
            $sponsorWithoutTree = $qb2->where($queryBuilder->expr()->notIn('rr.id',$sponsorWithTree->getDQL()))
                ->setFirstResult(0);
            $serialized = $this->get('jms_serializer')->
                serialize(count($sponsorWithoutTree->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array('sponsor.list')));





            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->select('count(n.id)');
            $queryBuilder->where('n.active= :active')
                ->setParameter('active', false)
                ->setFirstResult(0)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getSingleScalarResult();



            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }
        
        if($cid == -3) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->select('count(n.id)');
            $queryBuilder->orderBy('n.creationDate', 'Desc')
                ->setFirstResult(0)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getSingleScalarResult();



            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));

            return new Response(
                $serialized
                , 200);
        }

        
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:SponsorTree');
        /* @var $repository \Darkish\CategoryBundle\Entity\SponsorTreeRepository */
        $category =  $repository->find($cid);

        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category NewsTree */
//            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SponsorTree');
//            //$newsList = $repository->findBy(array('category' => $category->getTreeIndex()));
//
//            $queryBuilder = $repository->createQueryBuilder('n');
//            /* @var $queryBuilder QueryBuilder */
//            $queryBuilder->where('n.newstreeId = :ntid')
//                ->setParameter('ntid', $category->getId())
//                ->setFirstResult(($page-1) * $this->numPerPage)
//                ->setMaxResults($this->numPerPage)
//            ;
//
//
//            $query = $queryBuilder->getQuery();
//            $newsList =  $query->getResult();
            
            $children = $this->getTreeChildren($category);
            
            $treesIds = array();
            $treesIds[] = $category->getId();
            foreach($children as $child) {
                $treesIds[] = $child->getId();
            }
            /* @var $repository \Darkish\CategoryBundle\Entity\SponsorRepository */
            $repository = $this->getDoctrine()
                ->getRepository('DarkishCategoryBundle:Sponsor');
            $qb = $repository->createQueryBuilder('r'); 
            $qb->select('count(r.id)');
            $qb->join('r.trees','t', 'WITH',$qb->expr()->in('t.id', $treesIds))->distinct();
            $qb->orderBy('r.listRank', 'Asc');
            $res = $qb->setFirstResult(0)->getQuery()->getSingleScalarResult();
            
            $serialized = $this->get('jms_serializer')->
                serialize($res, 'json', SerializationContext::create()->setGroups(array('sponsor.list')));




//            $newsList = $category->getSponsors();
//            $encoders = array(new XmlEncoder(), new JsonEncoder());
//            $normalizers = array(new GetSetMethodNormalizer());
//
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $serialized = $serializer->serialize($newsList, 'json');

            return new Response(
                $serialized
                , 200);
        }

    }
}
            