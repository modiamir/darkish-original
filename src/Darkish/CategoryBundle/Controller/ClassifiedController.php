<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\ClassifiedLock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Darkish\CategoryBundle\Entity\Classified;
use Darkish\CategoryBundle\Entity\ClassifiedTree;
use Darkish\CategoryBundle\Form\ClassifiedType;
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


class ClassifiedController extends Controller
{
    private $numPerPage = 15;

    /**
     * Lists all Classified entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(!$user->routeAccess('classified')) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        $classified = new Classified();
//        if (false === $this->get('security.context')->isGranted('view', $classified)) {
//            throw new AccessDeniedException('Unauthorised access!');
//        }


        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:Classified')->findAll();




        return $this->render('DarkishCategoryBundle:Classified:index.html.php', array(
            'entities' => $entities,

        ));
    }

    public function updateAction(Request $request, $id) {
        
        
        try {
            $user = $this->getUser();
            $classified = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified')->find($id);
            
            if (false === $this->get('security.context')->isGranted('edit', $classified)) {
                throw new AccessDeniedException('Unauthorised access!');
            }
            
            $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
            $data = $serializer->deserialize($request->get('data'), 'array', 'json');
            /* @var $classified Classified*/
            
            
            $this->classifiedMassAssignment($classified, $data);
            $classified->setLastUpdate(new \DateTime());
            $classified->setHtmlLastUpdate(new \DateTime());
            $classified->setUser($user);
            
            if(!in_array('ROLE_ADMIN', $user->getRolesNames()) &&  !in_array('ROLE_SUPER_ADMIN', $user->getRolesNames())) {
                $classified->setVerify(false);
            }
            
            $validator = $this->get('validator');
            $errors = $validator->validate($classified);

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
                $em->persist($classified);
                
                $em->flush();
                
                $this->setContinualThumbnailAction($data['images'], $data['body_images'], $data['videos'], $data['body_videos'], $data['audios'], $data['body_audios'], $data['body_docs']);
                
                return new Response($serializer->serialize($classified, 'json', SerializationContext::create()->setGroups(array('classified.details'))));

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
            /* @var $classified Classified*/
            $classified = new Classified();
            $this->classifiedMassAssignment($classified, $data);
            $classified->setCreationDate(new \DateTime());
            $classified->setLastUpdate(new \DateTime());
            $classified->setHtmlLastUpdate(new \DateTime());
            $classified->setUser($user);

            //return new Response($serializer->serialize($classified, 'json'));

            $validator = $this->get('validator');
            $errors = $validator->validate($classified);

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
                $em->persist($classified);
                $em->flush();
                $data['images'] = (isset($data['images']))?$data['images']:[];
                $data['body_images'] = (isset($data['body_images']))?$data['body_images']:[];
                $data['videos'] = (isset($data['videos']))?$data['videos']:[];
                $data['body_videos'] = (isset($data['body_videos']))?$data['body_videos']:[];
                $data['audios'] = (isset($data['audios']))?$data['audios']:[];
                $data['body_audios'] = (isset($data['body_audios']))?$data['body_audios']:[];
                $data['body_docs'] = (isset($data['body_docs']))?$data['body_docs']:[];
                
                $this->setContinualThumbnailAction($data['images'], $data['body_images'], $data['videos'], $data['body_videos'], $data['audios'], $data['body_audios'], $data['body_docs']);
                
                

                return new Response($serializer->serialize(array($classified), 'json', SerializationContext::create()->setGroups(array('classified.details'))));

            };
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }



    }

    
    
    

    public function classifiedMassAssignment(Classified &$classified, $data) {

        if(isset($data['title'])) {
            $classified->setTitle($data['title']);
        }
        if(isset($data['sub_title'])) {
            $classified->setSubTitle($data['sub_title']);
        }

        if(isset($data['publish_date'])) {
            $date = new \DateTime($data['publish_date']);
            $classified->setPublishDate($date);
        }
        if(isset($data['expire_date'])) {
            $date = new \DateTime($data['expire_date']);
            $classified->setExpireDate($date);
        }
        
        if(isset($data['body'])) {
            $classified->setBody($data['body']);
        }
        if(isset($data['audio'])) {
            $classified->setAudio($data['audio']);
        }
        if(isset($data['video'])) {
            $classified->setVideo($data['video']);
        }
        
        if(isset($data['continual'])) {
            $classified->setContinual($data['continual']);
        }
        
        if(isset($data['immediate'])) {
            $classified->setImmediate($data['immediate']);
        }
        
        if(isset($data['list_rank'])) {
            $classified->setListRank($data['list_rank']);
        }
        
        
        
        if(isset($data['verify'])) {
            $classified->setVerify($data['verify']);
        } else {
            $classified->setVerify(false);
        }
        if(isset($data['active'])) {
            $classified->setActive($data['active']);
        } else {
            $classified->setActive(false);
        }
        
        if(isset($data['address'])) {
            $classified->setAddress($data['address']);
        }
        
        if(isset($data['tel_number_one'])) {
            $classified->setTelNumberOne($data['tel_number_one']);
        }
        if(isset($data['tel_number_two'])) {
            $classified->setTelNumberTwo($data['tel_number_two']);
        }
        if(isset($data['tel_number_three'])) {
            $classified->setTelNumberThree($data['tel_number_three']);
        }
        if(isset($data['tel_number_four'])) {
            $classified->setTelNumberFour($data['tel_number_four']);
        }
        if(isset($data['fax_number_one'])) {
            $classified->setFaxNumberOne($data['fax_number_one']);
        }
        if(isset($data['fax_number_two'])) {
            $classified->setFaxNumberTwo($data['fax_number_two']);
        }
        if(isset($data['mobile_number_one'])) {
            $classified->setMobileNumberOne($data['mobile_number_one']);
        }
        if(isset($data['mobile_number_two'])) {
            $classified->setMobileNumberTwo($data['mobile_number_two']);
        }
        if(isset($data['email'])) {
            $classified->setEmail($data['email']);
        }
        if(isset($data['website'])) {
            $classified->setWebsite($data['website']);
        }
        
        
        if(isset($data['icon'])) {
            $iconRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
            $em = $this->getDoctrine()->getManager();
            if(isset($data['icon']['id'])) {
                $icon = $iconRepo->find($data['icon']['id']);
                if($icon) {
                    $classified->setIcon($icon);
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
                $classified->setIcon();
            }
            
        }
        if(isset($data['banner'])) {
            $bannerRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
            $em = $this->getDoctrine()->getManager();
            if(isset($data['banner']['id'])) {
                $banner = $bannerRepo->find($data['banner']['id']);
                if($banner) {
                    $classified->setBanner($banner);
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
                $classified->setBanner();
            }
            
        }
        if(isset($data['trees'])) {
            $currentTrees = $classified->getTrees();
            $newTrees = new ArrayCollection();
            $eCollec = new ArrayCollection();
            $neCollec = new ArrayCollection();
            $rCollec = new ArrayCollection();
            $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ClassifiedTree');
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



            //$classified->setTrees($data['trees']);
        }
        if(isset($data['images'])) {

            $currentImages = $classified->getImages();
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



            //$classified->setImages($data['images']);
        }
        if(isset($data['body_images'])) {

            $currentBodyImages = $classified->getBodyImages();
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



            //$classified->setImages($data['images']);
        }
        if(isset($data['videos'])) {
            $currentVideos = $classified->getVideos();
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

            //$classified->setVideos($data['videos']);
        }
        if(isset($data['body_videos'])) {

            $currentBodyVideos = $classified->getBodyVideos();
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



            //$classified->setImages($data['images']);
        }
        if(isset($data['audios'])) {

            $currentAudios = $classified->getAudios();
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

            //$classified->setAudios($data['audios']);
        }
        if(isset($data['body_audios'])) {

            $currentBodyAudios = $classified->getBodyAudios();
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



            //$classified->setImages($data['images']);
        }
        
        if(isset($data['body_docs'])) {

            $currentBodyDocs = $classified->getBodyDocs();
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



            //$classified->setImages($data['images']);
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
            ->getRepository('DarkishCategoryBundle:ClassifiedTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product ClassifiedTree */
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

    public function containsTreeAction($classifiedId, $treeId) {
        try {
            /* @var $classified Classified */
            $classified =$this->getDoctrine()->getManager()->getRepository('DarkishCategoryBundle:Classified')->find($classifiedId);
            $trees = $classified->getTrees();
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
                serialize($currents, 'json', SerializationContext::create()->setGroups(array('classified.details'))));
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }


    public function getTreeLinearAction() {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:ClassifiedTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product ClassifiedTree */
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
        $Classified = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:Classified')
            ->find(1);

        $Tree = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:ClassifiedTree')
            ->find(1);

        /* @var $serializer JMSSerializer */
        $serializer = $this->get('jms_serializer');

        /* @var $Classified Classified */
        $Classified->addTree($Tree);



        return new Response(
            $serializer->serialize($Tree, 'json', SerializationContext::create()->setGroups(array('list', 'Default')))
        );
    }

    public function getClassifiedForCategoryAction($cid, $count) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
            //$classifiedList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.verify= :verify')
                ->setParameter('verify', false)
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $classifiedList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($classifiedList, 'json', SerializationContext::create()->setGroups(array('classified.list')));

            return new Response(
                $serialized
                , 200);
        }

        if($cid == 0) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
            //$classifiedList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('r');
            /* @var $queryBuilder QueryBuilder */
            $classifiedWithTree = $queryBuilder->select('r.id')->join('r.trees','t', 'WITH')->distinct();
            $qb2 = $repository->createQueryBuilder('rr');
            $classifiedWithoutTree = $qb2->where($queryBuilder->expr()->notIn('rr.id',$classifiedWithTree->getDQL()))
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage);
            $serialized = $this->get('jms_serializer')->
                serialize($classifiedWithoutTree->getQuery()->getResult(), 'json', SerializationContext::create()->setGroups(array('classified.list')));





            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
            //$classifiedList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.active= :active')
                ->setParameter('active', false)
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $classifiedList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($classifiedList, 'json', SerializationContext::create()->setGroups(array('classified.list')));

            return new Response(
                $serialized
                , 200);
        }
        
        if($cid == -3) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
            //$classifiedList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->orderBy('n.creationDate', 'Desc')
                ->setFirstResult($count)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $classifiedList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($classifiedList, 'json', SerializationContext::create()->setGroups(array('classified.list')));

            return new Response(
                $serialized
                , 200);
        }


        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:ClassifiedTree');
        /* @var $repository \Darkish\CategoryBundle\Entity\ClassifiedTreeRepository */
        $category =  $repository->find($cid);

        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category ClassifiedTree */
//            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ClassifiedTree');
//            //$classifiedList = $repository->findBy(array('category' => $category->getTreeIndex()));
//
//            $queryBuilder = $repository->createQueryBuilder('n');
//            /* @var $queryBuilder QueryBuilder */
//            $queryBuilder->where('n.classifiedtreeId = :ntid')
//                ->setParameter('ntid', $category->getId())
//                ->setFirstResult(($page-1) * $this->numPerPage)
//                ->setMaxResults($this->numPerPage)
//            ;
//
//
//            $query = $queryBuilder->getQuery();
//            $classifiedList =  $query->getResult();
            /* @var $repository \Darkish\CategoryBundle\Entity\ClassifiedRepository */
            $repository = $this->getDoctrine()
                ->getRepository('DarkishCategoryBundle:Classified');
            $qb = $repository->createQueryBuilder('r');
            $qb->join('r.trees','t', 'WITH','t.id = '. $category->getId())->distinct();
            $res = $qb->setFirstResult($count)
                ->setMaxResults($this->numPerPage)->getQuery()->getResult();
            
            $serialized = $this->get('jms_serializer')->
                serialize($res, 'json', SerializationContext::create()->setGroups(array('classified.list')));




//            $classifiedList = $category->getClassifieds();
//            $encoders = array(new XmlEncoder(), new JsonEncoder());
//            $normalizers = array(new GetSetMethodNormalizer());
//
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $serialized = $serializer->serialize($classifiedList, 'json');

            return new Response(
                $serialized
                , 200);
        }

    }


    public function searchClassifiedsAction($keyword, $search_by, $sort_by, $count = 0) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
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

        return new Response($this->get('jms_serializer')->serialize($res, 'json', SerializationContext::create()->setGroups(array('classified.list'))));
    }

    

    public function getClassifiedAction($id) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
        $classified = $repository->find($id);

        if(!$classified) {
            return new Response("Classified ID is invalid", 404);
        }
//        return new Response($this->get('jms_serializer')->serialize($classified, 'json'));
        return new Response($this->get('jms_serializer')->serialize($classified, 'json', SerializationContext::create()->setGroups(array('classified.details'))));
    }


    public function generateCsrfAction() {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken(''); //Intention should be empty string, if you did not define it in parameters
        return new Response($token);
    }

    public function verifyClassifiedAction($classifiedId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Classified');
        $classified = $repo->find($classifiedId);

        if(!$classified) {
            return new Response('classified_id is invalid!', 404);
        }
        /* @var $classified Classified */
        $classified->setVerify(true);
        $em->persist($classified);
        $em->flush();

        return new Response('Classified verified.');

    }


    public function toggleVerifyClassifiedAction($classifiedId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Classified');
        $classified = $repo->find($classifiedId);

        if(!$classified) {
            return new Response('classified_id is invalid!', 404);
        }
        /* @var $classified Classified */
        $classified->setVerify(!$classified->getVerify());
        $em->persist($classified);
        $em->flush();

        return new JsonResponse(array('verify' => $classified->getVerify()));

    }

    public function deleteClassifiedAction($classifiedId) {
        try{
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DarkishCategoryBundle:Classified');
            $classified = $repo->find($classifiedId);
            /* @var $classified Classified */
            $em->remove($classified);
            $em->flush();
            return new Response('Classified deleted');
        } catch(\Doctrine\ORM\ORMInvalidArgumentException $e) {
            return new Response('Classified Not found', 404);
        }



    }


    public function getUsernameAction() {
        /* @var $sc \Symfony\Component\Security\Core\SecurityContext */
        $sc = $this->get('security.context');

        return new Response($sc->getToken()->getUsername());
    }

    public function toggleActiveClassifiedAction($classifiedId) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Classified');
        $classified = $repo->find($classifiedId);

        if(!$classified) {
            return new Response('classified_id is invalid!', 404);
        }
        /* @var $classified Classified */
        $classified->setActive(!$classified->getActive());
        $em->persist($classified);
        $em->flush();
        return new JsonResponse(array('active' => $classified->getActive()));

    }

    public function accessAction() {
        $classified = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified')->find(1);
        $voter = $this->get('security.context');

        return new JsonResponse($voter->isGranted('view', $classified));
    }

    
    
    public function checkPermissionAction($attribute, $id = null) {
        try {
            if($id) {
                $classified = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified')->find($id);
            }else {
                $classified = new Classified();
            }
            $granted = $this->get('security.context')->isGranted($attribute, $classified);
            return new JsonResponse(array($granted));
        } catch(Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
        
        return new JsonResponse(array($attribute,$class, $id));
    }
    
    public function getClassifiedByIdAction($id) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Classified');
            $classified = $repo->find($id);
            if($classified) {
                return new Response($this->get('jms_serializer')->serialize($classified, 'json', SerializationContext::create()->setGroups(array('classified.details'))));
            } else {
                return new Response('Not found', 404);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
            
    }
    
    public function getTreeByIndexAction($index) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ClassifiedTree');
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
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ClassifiedTree');
        return new Response($this->get('jms_serializer')->serialize($repo->find($id), 'json'));
    }
}
            