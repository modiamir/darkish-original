<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

class ManagedFileController extends Controller
{
    public function uploadAction(Request $request)
    {


        /* @var $form Form  */

        $file = new ManagedFile();
        $file->setStatus(0);
        $file->setTimestamp(new \DateTime());
        $file->setUserId($this->getUser()->getId());


        if($request->files->has('file')) {
            $file->setFile($request->files->get('file'));
        }

        if($request->request->has('type')){
            $file->setType($request->get('type'));
        }

        if($request->request->has('entityId')){
            $file->setEntityId($request->get('entityId'));
        }
        if($request->request->has('uploadKey')) {
            $file->setUploadKey($request->get('uploadKey'));
        }

        if($request->request->has('uploadDir')){
            $file->setUploadDir($request->get('uploadDir'));
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($file);


        if(count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();

            $file->upload();


        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($file);
        if(count($errors) == 0) {
            $em->persist($file);
            $em->flush();


            if($request->get('entityId')) {

            }

            $serializer = $this->get('jms_serializer');
            $serialized = $serializer->serialize($file, 'json');
//            $serialized = $serializer->serialize($file, 'json');



            return new Response($serialized);
        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }













    }

    public function generateRandomUploadKeyAction() {
        return new Response($this->getUser()->getId().time().rand(1000,9999));

    }
}
