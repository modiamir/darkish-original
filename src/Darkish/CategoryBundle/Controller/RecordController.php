<?php

namespace Darkish\CategoryBundle\Controller;

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


class RecordController extends Controller
{
    private $numPerPage = 10;

    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:Record')->findAll();




        return $this->render('DarkishCategoryBundle:Record:index.html.php', array(
            'entities' => $entities,

        ));
    }

    public function updateAction(Request $request, $id) {
        try {
            $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
            $data = $serializer->deserialize($request->get('data'), 'array', 'json');
            /* @var $record Record*/
            $record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($id);
            $this->recordMassAssignment($record, $data);

            //return new Response($serializer->serialize($record, 'json'));

            $validator = $this->get('validator');
            $errors = $validator->validate($record);

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
                $em->persist($record);
                $em->flush();
                return new Response($serializer->serialize($record, 'json'));

            };
        }catch (\Exception $e) {
            return new Response(
                $e->getLine().'<br/>'.
                $e->getMessage().'<br/>'.
                $e->getCode().'<br/>'.
                $e->getFile().'<br/>'.
                $e->getTraceAsString(), 403
            );
        }



    }


    public function createAction(Request $request) {
        try {
            $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
            $data = $serializer->deserialize($request->get('data'), 'array', 'json');
            /* @var $record Record*/
            $record = new Record();
            $this->recordMassAssignment($record, $data);

            //return new Response($serializer->serialize($record, 'json'));

            $validator = $this->get('validator');
            $errors = $validator->validate($record);

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
                $em->persist($record);
                $em->flush();

                /*
                 * bad az zakhire kardane recorde jadid be donbale image haei ke ba upload key
                 * dade shode motabegh hastand migardad ta anha ra be recorde jadid assign konad
                 */

                return new Response($serializer->serialize(array($record), 'json'));

            };
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 403);
        }



    }


    public function recordMassAssignment(Record &$record, $data) {

        if(isset($data['record_number'])) {
            $record->setRecordNumber($data['record_number']);
        }
        if(isset($data['title'])) {
            $record->setTitle($data['title']);
        }
        if(isset($data['sub_title'])) {
            $record->setSubTitle($data['sub_title']);
        }

        if(isset($data['english_title'])) {
            $record->setEnglishTitle($data['english_title']);
        }
        if(isset($data['english_sub_title'])) {
            $record->setEnglishSubTitle($data['english_sub_title']);
        }
        if(isset($data['arabic_title'])) {
            $record->setArabicTitle($data['arabic_title']);
        }
        if(isset($data['arabic_sub_title'])) {
            $record->setArabicSubTitle($data['arabic_sub_title']);
        }

        if(isset($data['turkish_title'])) {
            $record->setTurkishTitle($data['turkish_title']);
        }
        if(isset($data['turkish_sub_title'])) {
            $record->setTurkishSubTitle($data['turkish_sub_title']);
        }
        
        if(isset($data['owner'])) {
            $record->setOwner($data['owner']);
        }
        if(isset($data['legal_name'])) {
            $record->setLegalName($data['legal_name']);
        }
        if(isset($data['center_floor'])) {
            $record->setCenterFloor($data['center_floor']);
        }
        if(isset($data['body'])) {
            $record->setBody($data['body']);
        }
        if(isset($data['center_unit_number'])) {
            $record->setCenterUnitNumber($data['center_unit_number']);
        }
        if(isset($data['message_enable'])) {
            $record->setMessageEnable($data['message_enable']);
        }
        if(isset($data['message_text'])) {
            $record->setMessageText($data['message_text']);
        }
        if(isset($data['message_insert_date'])) {
            $record->setMessageInsertDate($data['message_insert_date']);
        }
        if(isset($data['message_validity_date'])) {
            $record->setMessageValidityDate($data['message_validity_date']);
        }
        if(isset($data['safarsaz'])) {
            $record->setSafarsaz($data['safarsaz']);
        }
        if(isset($data['safarsaz_rank'])) {
            $record->setSafarsazRank($data['safarsaz_rank']);
        }
        if(isset($data['tel_number_one'])) {
            $record->setTelNumberOne($data['tel_number_one']);
        }
        if(isset($data['tel_number_two'])) {
            $record->setTelNumberTwo($data['tel_number_two']);
        }
        if(isset($data['tel_number_three'])) {
            $record->setTelNumberThree($data['tel_number_three']);
        }
        if(isset($data['tel_number_four'])) {
            $record->setTelNumberFour($data['tel_number_four']);
        }
        if(isset($data['fax_number_one'])) {
            $record->setFaxNumberOne($data['fax_number_one']);
        }
        if(isset($data['fax_number_two'])) {
            $record->setFaxNumberTwo($data['fax_number_two']);
        }
        if(isset($data['mobile_number_one'])) {
            $record->setMobileNumberOne($data['mobile_number_one']);
        }
        if(isset($data['mobile_number_two'])) {
            $record->setMobileNumberTwo($data['mobile_number_two']);
        }
        if(isset($data['email'])) {
            $record->setEmail($data['email']);
        }
        if(isset($data['website'])) {
            $record->setWebsite($data['website']);
        }
        if(isset($data['address'])) {
            $record->setAddress($data['address']);
        }
        if(isset($data['longitude'])) {
            $record->setLongitude($data['longitude']);
        }
        if(isset($data['latitude'])) {
            $record->setLatitude($data['latitude']);
        }
        if(isset($data['reserved1'])) {
            $record->setReserved1($data['reserved1']);
        }
        if(isset($data['reserved2'])) {
            $record->setReserved2($data['reserved2']);
        }
        if(isset($data['brand_enable'])) {
            $record->setBrandEnable($data['brand_enable']);
        }
        if(isset($data['list_rank'])) {
            $record->setListRank($data['list_rank']);
        }
        if(isset($data['m_opening_hours_from'])) {
            $record->setMOpeningHoursFrom($data['m_opening_hours_from']);
        }
        if(isset($data['m_opening_hours_to'])) {
            $record->setMOpeningHoursTo($data['m_opening_hours_to']);
        }
        if(isset($data['a_opening_hours_from'])) {
            $record->setAOpeningHoursFrom($data['a_opening_hours_from']);
        }
        if(isset($data['a_opening_hours_to'])) {
            $record->setAOpeningHoursTo($data['a_opening_hours_to']);
        }
        if(isset($data['working_days'])) {
            $record->setWorkingDays($data['working_days']);
        }
        if(isset($data['search_keywords'])) {
            $record->setSearchKeywords($data['search_keywords']);
        }
        if(isset($data['creation_date'])) {
            $creation_date = new \DateTime($data['creation_date']);
            $record->setCreationDate($creation_date);
        }
        if(isset($data['last_update'])) {
            $last_update = new \DateTime($data['last_update']);
            $record->setLastUpdate($last_update);
        }
        if(isset($data['favorite_enable'])) {
            $record->setFavoriteEnable($data['favorite_enable']);
        }
        if(isset($data['like_enable'])) {
            $record->setLikeEnable($data['like_enable']);
        }
        if(isset($data['send_sms_enable'])) {
            $record->setSendSmsEnable($data['send_sms_enable']);
        }
        if(isset($data['info_key_enable'])) {
            $record->setInfoKeyEnable($data['info_key_enable']);
        }
        if(isset($data['comment_enable'])) {
            $record->setCommentEnable($data['comment_enable']);
        }
        if(isset($data['only_html'])) {
            $record->setOnlyHtml($data['only_html']);
        }
        if(isset($data['online_enable'])) {
            $record->setOnlineEnable($data['online_enable']);
        }
        if(isset($data['dbase_enable'])) {
            $record->setDbaseEnable($data['dbase_enable']);
        }
        if(isset($data['bulk_sms_enable'])) {
            $record->setBulkSmsEnable($data['bulk_sms_enable']);
        }
        if(isset($data['audio'])) {
            $record->setAudio($data['audio']);
        }
        if(isset($data['video'])) {
            $record->setVideo($data['video']);
        }
        if(isset($data['online_market'])) {
            $record->setOnlineMarket($data['online_market']);
        }
        if(isset($data['online_ticket'])) {
            $record->setOnlineTicket($data['online_ticket']);
        }
        if(isset($data['visit_count'])) {
            $record->setVisitCount($data['visit_count']);
        }
        if(isset($data['favorite_count'])) {
            $record->setFavoriteCount($data['favorite_count']);
        }
        if(isset($data['like_count'])) {
            $record->setLikeCount($data['like_count']);
        }
        if(isset($data['verify'])) {
            $record->setVerify($data['verify']);
        }
        if(isset($data['center_index'])) {
            //$record->setCenterIndex($data['center_index']);
        }
        if(isset($data['area_index'])) {
            //$record->setAreaIndex($data['area_index']);
        }
        if(isset($data['safarsaz_type_index'])) {
            //$record->setSafarsazTypeIndex($data['safarsaz_type_index']);
        }
        if(isset($data['dbase_type_index'])) {
            //$record->setDbaseTypeIndex($data['dbase_type_index']);
        }
        if(isset($data['trees'])) {
            $currentTrees = $record->getTrees();
            $newTrees = new ArrayCollection();
            $eCollec = new ArrayCollection();
            $neCollec = new ArrayCollection();
            $rCollec = new ArrayCollection();
            $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree');
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



            //$record->setTrees($data['trees']);
        }
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
        if(isset($data['audios'])) {

            $currentAudios = $record->getAudios();
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

            //$record->setAudios($data['audios']);
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
    }

    public function getTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product NewsTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }

    public function containsTreeAction($recordId, $treeId) {
        try {
            /* @var $record Record */
            $record =$this->getDoctrine()->getManager()->getRepository('DarkishCategoryBundle:Record')->find($recordId);
            $trees = $record->getTrees();
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
                serialize($currents, 'json', SerializationContext::create()->setGroups(array('record.details'))));
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }


    public function getTreeLinearAction() {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product NewsTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $tree[$key] = $node;
        }

        return new Response(
            json_encode($tree),
            200
        );
    }



    private function buildTree(array $elements, $parentId = "#") {
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
        $Record = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:Record')
            ->find(1);

        $Tree = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree')
            ->find(1);

        /* @var $serializer JMSSerializer */
        $serializer = $this->get('jms_serializer');

        /* @var $Record Record */
        $Record->addTree($Tree);



        return new Response(
            $serializer->serialize($Tree, 'json', SerializationContext::create()->setGroups(array('list', 'Default')))
        );
    }

    public function getRecordForCategoryAction($cid, $page) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.verify= :verify')
                ->setParameter('verify', false)
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('record.list')));

            return new Response(
                $serialized
                , 200);
        }

        if($cid == 0) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
            //$newsList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('r');
            /* @var $queryBuilder QueryBuilder */
            $recordWithTree = $queryBuilder->select('r.id')->join('r.trees','t', 'WITH')->distinct();
            $qb2 = $repository->createQueryBuilder('rr');
            $recordWithoutTree = $qb2->where($queryBuilder->expr()->notIn('rr.id',$recordWithTree->getDQL()));
            $serialized = $this->get('jms_serializer')->
                serialize($recordWithoutTree->getQuery()->getResult(), 'json', SerializationContext::create()->setGroups(array('record.list')));





            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.active= :active')
                ->setParameter('active', false)

            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getResult();



            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('record.list')));

            return new Response(
                $serialized
                , 200);
        }


        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');

        $category =  $repository->find($cid);
        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category NewsTree */
//            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree');
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


            $serialized = $this->get('jms_serializer')->
                serialize($category->getRecords(), 'json', SerializationContext::create()->setGroups(array('record.list')));




//            $newsList = $category->getRecords();
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


    public function searchRecordsAction($keyword, $search_by, $sort_by) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $qb = $repo->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        switch($search_by) {
            case '1':
                $qb->where($qb->expr()->like('r.title', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            case '2':
                $qb->where($qb->expr()->like('r.recordNumber', $qb->expr()->literal('%' . $keyword . '%')));
                break;
            case '3':

                break;
            default:

                break;
        }

        switch($sort_by) {
            case '4':
                $qb->orderBy('r.recordNumber', 'Asc');
                break;
            case '3':
                $qb->orderBy('r.recordNumber', 'Desc');
                break;
            case '2':
                $qb->orderBy('r.creationDate', 'Asc');
                break;
            default:
                $qb->orderBy('r.creationDate', 'Desc');
                break;
        }

        $res = $qb->getQuery()->getResult();

        return new Response($this->get('jms_serializer')->serialize($res, 'json', SerializationContext::create()->setGroups(array('record.list'))));
    }

    public function isUniqeRecordNumberAction($recordNumber) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $record = $repo->findByRecordNumber($recordNumber);
        return new Response(count($record));
    }

    public function getRecordAction($id) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $record = $repository->find($id);

        if(!$record) {
            return new Response("Record ID is invalid", 404);
        }

        return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(array('record.details'))));
    }

    public function getCentersAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Center');
        $centers = $repository->findAll();
        return new Response($this->get('jms_serializer')->serialize($centers, 'json', SerializationContext::create()->setGroups(array('center.list'))));
    }

    public function getSafarsazTypesAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:SafarsazType');
        $centers = $repository->findAll();
        return new Response($this->get('jms_serializer')->serialize($centers, 'json', SerializationContext::create()->setGroups(array('safarsaz.list'))));
    }

    public function getDbaseTypesAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:DbaseType');
        $centers = $repository->findAll();
        return new Response($this->get('jms_serializer')->serialize($centers, 'json', SerializationContext::create()->setGroups(array('dbase.list'))));
    }

    public function getAreasAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Area');
        $centers = $repository->findAll();
        return new Response($this->get('jms_serializer')->serialize($centers, 'json', SerializationContext::create()->setGroups(array('area.list'))));
    }

    public function generateCsrfAction() {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken(''); //Intention should be empty string, if you did not define it in parameters
        return new Response($token);
    }

    public function verifyRecordAction($recordId) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DarkishCategoryBundle:Record');
        $record = $repo->find($recordId);

        if(!$record) {
            return new Response('record_id is invalid!', 404);
        }
        /* @var $record Record */
        $record->setVerify(true);
        $em->persist($record);
        $em->flush();

        return new Response('Record verified.');

    }

    public function accessAction() {
        $record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find(1);
        return new JsonResponse($this->get('security.context')->isGranted('view', $record));
    }
}
