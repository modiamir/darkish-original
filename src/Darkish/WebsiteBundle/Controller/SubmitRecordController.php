<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\WebsiteBundle\Form\SubmitRecordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkish\CategoryBundle\Entity\SubmitRecord;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SubmitRecordController
 * @Route("/", host="%domain%")
 */
class SubmitRecordController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/submit/record", name="website_submit_record")
     */
    public function indexAction(Request $request)
    {
        $submitRecord = new SubmitRecord();
        $form = $this->createForm(new SubmitRecordType(), $submitRecord);
        $submitted = false;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($submitRecord);
            $em->flush();
            global $submitted;
            $submitted = true;
        }

        return $this->render('DarkishWebsiteBundle:Submit:index.html.twig', [
            'form' => $form->createView(),
            'submitted' => $submitted
        ]);
    }


    /**
     * @Route("get_files")
     */
    public function getFileAction(Request $request)
    {

        $manager = $this->get('oneup_uploader.orphanage_manager')->get('image');
        // get files
        /* @var $manager \Oneup\UploaderBundle\Uploader\Storage\FilesystemOrphanageStorage */
        $files = $manager->getFiles();
//
        $files->files()->name('file-1441720869-33642.jpg');

        foreach($files as $f) {
            $file = $f;
            break;
        }


        /* @var $file \Symfony\Component\Finder\SplFileInfo */

//        $manager->uploadFiles($file);
        return new Response($this->get('jms_serializer')->serialize($file,'json'));
    }
}
