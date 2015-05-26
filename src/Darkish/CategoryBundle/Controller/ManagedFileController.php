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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use \GetId3\GetId3Core as GetId3;
use FFMpeg\FFProbe;
use Exception;


class ManagedFileController extends Controller
{
    public function uploadAction(Request $request)
    {

        try {
            /* @var $form Form  */

            $file = new ManagedFile();
            $file->setStatus(0);
            $file->setTimestamp(new \DateTime());
            $file->setUserId($this->getUser()->getId());


            if($request->files->has('file')) {
                $ufile = $request->files->get('file');
                if(substr($ufile->getMimeType(), 0, 5) != 'image' && substr($ufile->getMimeType(), 0, 11) != 'application') {
                    $tmpName = time().'-'.rand(100000,999999).'.'.$ufile->getClientOriginalExtension();
                    $ufile->move('/tmp', $tmpName);
                    $ufile = new File('/tmp/'.$tmpName, true);

                    $ffprobe = FFProbe::create();


                    if($ffprobe->streams($ufile->getRealPath())->first()->isVideo()) {
                        
                        $duration = $ffprobe
                            ->format($ufile->getRealPath()) // extracts file informations
                            ->get('duration');             // returns the duration property

                        if( $duration > 600) {
                            // return new Response("طول فایل بارگذاری شده نباید بیشتر از ۵ دقیقه باشد.", 500);
                            throw new \Exception("طول فایل بارگذاری شده نباید بیشتر از ۵ دقیقه باشد.", 445);
                        }





                        
                        $ffmpeg = $this->get('dubture_ffmpeg.ffmpeg');
                        $video = $ffmpeg->open('/tmp'.'/'.$tmpName);
                        if($ffprobe->streams($ufile->getRealPath())->first()->get('width') > 480 ||
                            $ffprobe->streams($ufile->getRealPath())->first()->get('height') > 320
                        ) {
                            $video
                                ->filters()
                                ->resize(new Dimension(480, 320), ResizeFilter::RESIZEMODE_INSET)
                                ->synchronize();
                            // Start transcoding and save video
                            $newTmpName = time().'-'.rand(100000,999999).'-resized.'.$ufile->getExtension();
                            $format = new X264();
                            $format->setAudioCodec('libmp3lame');
                            if($video->save($format, '/tmp/'.$newTmpName)) {
                                $ufile = new File('/tmp/'.$newTmpName, true);
                                    
                            }    
                        }
                        

                    }

                    if($ffprobe->streams($ufile->getRealPath())->first()->isAudio()) {
                        
                        
                        $ffprobe = FFProbe::create();
                        $duration = $ffprobe
                            ->format($ufile->getRealPath()) // extracts file informations
                            ->get('duration');             // returns the duration property

                        if( $duration > 600) {
                            // return new Response(, 500);
                            throw new \Exception("طول فایل بارگذاری شده نباید بیشتر از ۱۰ دقیقه باشد.", 445);
                            
                        }



                        $ffmpeg = $this->get('dubture_ffmpeg.ffmpeg');
                        $audio = $ffmpeg->open('/tmp'.'/'.$tmpName);

                        $format = new \FFMpeg\Format\Audio\Mp3();
                        $format
                            -> setAudioChannels(2)
                            -> setAudioKiloBitrate(64);
                        $newTmpName = time().'-'.rand(100000,999999).'-resized.'.$ufile->getExtension();
                        if($audio->save($format, '/tmp/'.$newTmpName)) {
                            $ufile = new File('/tmp/'.$newTmpName, true);
                                
                        }  

                        

                    }
                }
                

                $file->setFile($ufile);
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
            
            if($request->request->has('continual')) {
                $file->setContinual($request->get('continual'));
            } else {
                $file->setContinual(false);
            }

            $validator = $this->get('validator');
            $errors = $validator->validate($file);


            if(count($errors) == 0) {
                $em = $this->getDoctrine()->getManager();

                $file->upload();


            } else {
                $errorsString = (string) $errors;

                // return new Response($errorsString, 401);
                throw new \Exception($errorsString, 445);
                
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

                // return new Response($errorsString);
                throw new \Exception($errorsString, 445);
            }

        }
        catch (\Exception $e) {
            return new Response( $e->getMessage(), 401);
        }

        













    }

    
    /**
     * 
     * @return Response
     * @Template()
     */
    public function ffmpegTestAction() {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
        $file = $repo->find(440);
        $mp3File = $file->getUploadRootDir().'/'.$file->getFileName();
        $getId3 = new GetId3();
        $audio = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze($mp3File)
        ;

        if (isset($audio['error'])) {
            throw new \RuntimeException(sprintf('Error at reading audio properties from "%s" with GetId3: %s.', $mp3File, $audio['error']));
        }           
        // ...

        return new Response(print_r($audio['playtime_seconds'],true));
    }


    public function nervghAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        return new Response($serializer->serialize($request->files->get('file'), 'json', SerializationContext::create()->setGroups(array('file.details'))));
        
        
    }

    public function generateRandomUploadKeyAction() {
        return new Response($this->getUser()->getId().time().rand(1000,9999));

    }
    
    public function setContinualThumbnailAction(Request $request) {
        $serializer = $this->get('jms_serializer');
            /* @var $serializer JMSSerializer */
        $data = $serializer->deserialize($request->get('data'), 'array', 'json');
        $images = $data['images'];
        $videos = $data['videos'];
        $audios = $data['audios'];
        
        $body_images = $data['body_images'];
        $body_audios = $data['body_audios'];
        $body_videos = $data['body_videos'];
        
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
        $em = $this->getDoctrine()->getManager();
        
        $files = array_merge($images, $audios, $videos, $body_audios, $body_images, $body_videos);
        
        
        /**
         * settings isThumbnail and continual for files
         */
        
        foreach($files as $key => $file) {
            /* @var $managedFile \Darkish\CategoryBundle\Entity\ManagedFile */
            $managedFile = $repo->find($file['id']);
            $managedFile->setIsThumbnail($file['is_thumbnail']);
            $managedFile->setContinual($file['continual']);
            
            $em->persist($managedFile);
            
        }
        $em->flush();
        return new Response('Operation done succesfully', 200);
        
    }
}
