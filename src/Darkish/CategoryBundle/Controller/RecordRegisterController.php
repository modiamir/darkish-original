<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\RecordLock;
use Darkish\CategoryBundle\Entity\RecordMainTree;
use Doctrine\Common\Collections\ArrayCollection as Collection;
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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkish\CategoryBundle\Entity\RecordRegisterCode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class RecordRegisterController extends Controller
{
    /**
     * @Route("single/{record}/{regenerate}", defaults={ "_format" = "json", "regenerate" = 0 })
     */
    public function generateRegisterCodeSingle(Record $record, $regenerate) {
        
        $regCode = $this->generateCode($record, (boolean) $regenerate);

        if($regCode === 0) {
            return new JsonResponse(['code' => 0, 'message' => 'This Record has used registration code'], 500);
        }

        if($regCode === -1) {
            return new JsonResponse(['code' => -1, 'message' => 'This Record has registration code'], 500);
        }

        return new Response($this->get('jms_serializer')->serialize($regCode, 'json'));
    }

    /**
     * @Route("range/{from}/{to}/{regenerate}",  defaults={ "_format" = "json", "regenerate" = 0 })
     * @Method({"POST"})
     */
    public function generateRegisterCodeRange($from, $to, $regenerate) {
        $from = (int) $from;
        $to = (int) $to;

        if($from >= $to) {
            return new JsonResponse(['code'=>1, 'message' => '"from" should be lower than "to"'], 500);
        }

        if($from >999999 || $from <=0) {
            return new JsonResponse(['code'=>2, 'message' => '"from" should be in range (0, 999999] '], 500);
        }

        if($to >999999 || $to <=0) {
            return new JsonResponse(['code'=>3, 'message' => '"to" should be in range (0, 999999] '], 500);
        }

        $numbers = [];
        for($i = $from; $i <= $to; $i++) {
            $numbers[] = $this->intToRecordNumber($i);
        }

        // return new Response($this->get('jms_serializer')->serialize($numbers, 'json'), 500);

        $qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
                   ->createQueryBuilder('r');
        $qb->where('r.recordNumber in (:numbers)')->setParameter('numbers', $numbers);

        $records = $qb->getQuery()->getResult();

        $existings = [];
        
        foreach ($records as $key => $record) {
            $existings[] = $record->getRecordNumber();
        }

        $notExistings = array_diff($numbers, $existings);

        foreach ($notExistings as $key => $value) {
            $newRecord = new Record();
            $newRecord->setRecordNumber($value);
            $newRecord->setCustomerRegisterUsed(false);
            $records[] = $newRecord;
        }

        $generateds = new Collection();

        foreach ($records as $record) {
            if(($generated = $this->generateCode($record, $regenerate)) instanceof RecordRegisterCode) {
                $generateds->add($generated);
            }
        }

        

        return new Response($this->get('jms_serializer')->serialize($generateds, 'json'));
    }

    /**
     * @Route("group", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function generateRegisterCodeGroup(Request $request) {
        if(!$request->request->has('records')) {
            return new Response('Missing record ids', 500);
        }
        $recordsIds = $request->get('records');
        $qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
                                  ->createQueryBuilder('r');
        $qb->where('r.id in (:recordsIds)')->setParameter('recordsIds', $recordsIds);
        // $qb->join('\Darkish\CategoryBundle\Entity\RecordRegisterCode', 'rrc', 'WITH', 'r.recordNumber = rrc.recordNumber');
        $qb->setParameter('recordsIds', $recordsIds);
        
        $records = $qb->getQuery()->getResult();

        $regenerate = ($request->request->has('regenerate') && $request->get('regenerate') == 1)? true : false;

        $generateds = new Collection();

        foreach ($records as $record) {
            if(($generated = $this->generateCode($record, $regenerate)) instanceof RecordRegisterCode) {
                $generateds->add($generated);
            }
        }

        

        return new Response($this->get('jms_serializer')->serialize($generateds, 'json'));

    }



    private function generateCode(Record $record, $regenerate = false) {
        if($record->getCustomerRegisterUsed()) {
            return 0;
        }

        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
        $codes = $repo->findBy(['recordNumber' => $record->getRecordNumber()]);

        if(count($codes) && $codes[0]->getUsed() ) {
            return 0;
        }


        if(!$regenerate && count($codes) ) {
            return -1;
        }

        

        if(count($codes)) {
            $regCode = $codes[0];

        } else {
            $regCode = new RecordRegisterCode();
            $regCode->setCreated(new \Datetime());
        }

        $regCode->setRecordNumber($record->getRecordNumber());
        $regCode->setUsername(rand(10000,99999).$record->getRecordNumber());
        $regCode->setPassword(rand(10000000, 99999999));
        $regCode->setUsed(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($regCode);
        $em->flush();

        return $regCode;
    }

    private function intToRecordNumber($int) {
        $count = strlen($int);
        $numOfZeros = 6 - $count;

        for($i = 1;$i<=$numOfZeros; $i++) {
            $int = '0'. $int;
        }
        return $int;
    }

    


    /**
     * @Route("download/range/{from}/{to}/{new}", defaults={"new" = 0})
     */
    public function getCodesAsPdfRange($from, $to, $new) {
       
        $from = (int) $from;
        $to = (int) $to;

        if($from >= $to) {
            return new JsonResponse(['code'=>1, 'message' => '"from" should be lower than "to"'], 500);
        }

        if($from >999999 || $from <=0) {
            return new JsonResponse(['code'=>2, 'message' => '"from" should be in range (0, 999999] '], 500);
        }

        if($to >999999 || $to <=0) {
            return new JsonResponse(['code'=>3, 'message' => '"to" should be in range (0, 999999] '], 500);
        }

        $numbers = [];
        for($i = $from; $i <= $to; $i++) {
            $numbers[] = $this->intToRecordNumber($i);
        }

        // return new Response($this->get('jms_serializer')->serialize($numbers, 'json'));

        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
        $qb = $repo->createQueryBuilder('rrc');
        $qb->where('rrc.recordNumber in (:numbers)')->setParameter('numbers', $numbers);
        if($new == 1) {
            $qb->andWhere('rrc.printed = :printed')->setParameter('printed', false);
        }
        $codes = $qb->getQuery()->getResult();
        if($new == 1) {
            $qbInc = $repo->createQueryBuilder('rrc');
            $qbInc->update();
            $qbInc->set('rrc.printed', ':printed')->setParameter('printed', true);
            $qbInc->where('rrc.recordNumber in (:numbers)')->setParameter('numbers', $numbers);
            $qbInc->getQuery()->getResult();
        }

        // return new Response($this->get('jms_serializer')->serialize($codes, 'json'));        

        
        $html = $this->renderView('DarkishCategoryBundle:PDF:record_register_codes.html.twig', array(
            'codes'  => $codes
        ));

        // return $this->render('DarkishCategoryBundle:PDF:record_register_codes.html.twig', array(
        //     'codes'  => $codes
        // ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

    /**
     * @Route("download/{ids}/{type}/{new}",  name="download_register_code")
     */
    public function getCodesAsPdf($ids, $type, $new) {
       
        if($type == 'code') {
            $codeIds = json_decode(base64_decode($ids));
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
            $qb = $repo->createQueryBuilder('rrc');
            $qb->where('rrc.id in (:codeIds)')->setParameter('codeIds', $codeIds);
            if($new == 1) {
                $qb->andWhere('rrc.printed = :printed')->setParameter('printed', false);
            }
            $codes = $qb->getQuery()->getResult();
            if($new == 1) {
                $qbInc = $repo->createQueryBuilder('rrc');
                $qbInc->update();
                $qbInc->set('rrc.printed', ':printed')->setParameter('printed', true);
                $qbInc->where('rrc.id in (:codeIds)')->setParameter('codeIds', $codeIds);
                $qbInc->getQuery()->getResult();
            }
        } else {
            $recordNumbers = json_decode(base64_decode($ids));
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
            $qb = $repo->createQueryBuilder('rrc');
            $qb->where('rrc.recordNumber in (:recordNumbers)')->setParameter('recordNumbers', $recordNumbers);
            if($new == 1) {
                $qb->andWhere('rrc.printed = :printed')->setParameter('printed', false);
            }
            $codes = $qb->getQuery()->getResult();
            if($new == 1) {
                $qbInc = $repo->createQueryBuilder('rrc');
                $qbInc->update();
                $qbInc->set('rrc.printed', ':printed')->setParameter('printed', true);
                $qbInc->where('rrc.recordNumber in (:recordNumbers)')->setParameter('recordNumbers', $recordNumbers);
                $qbInc->getQuery()->getResult();
            }
        }

        

        
        $html = $this->renderView('DarkishCategoryBundle:PDF:record_register_codes.html.twig', array(
            'codes'  => $codes
        ));

        // return $this->render('DarkishCategoryBundle:PDF:record_register_codes.html.twig', array(
        //     'codes'  => $codes
        // ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
