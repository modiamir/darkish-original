<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;
use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Doctrine\Common\Collections\ArrayCollection as Collection;


class DefaultController extends Controller
{

	private $fixedRecords;



    public function indexAction($name)
    {

        
        return $this->render('DarkishCategoryBundle:Default:index.html.twig', array('name' => $name));
    }

    public function testJsonAction() {
        return new Response($this->get('jms_serializer')->serialize(['with json character' => '{asd, "asd"}'],'json'));
    }


    public function fixAction() {
    	$qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->createQueryBuilder('r');
    	// $qb->setMaxResults(50);
    	$qb->orderBy('r.id', 'Asc');
    	// $qb->where('r.id = :rid')->setParameter('rid', 68);
    	// $qb->where('r.id = :rid')->setParameter('rid', 616);
    	// $qb->where('r.id = :rid')->setParameter('rid', 86);
    	$records = $qb->getQuery()->getResult();
    	// return new Response(count($records));
    	$hasImageWithoutClass = [];
    	// return new Response($this->get('jms_serializer')->serialize($records[0], 'json', SerializationContext::create()->setGroups(array('record.details'))));
    	foreach ($records as $key => $record) {
			if($this->hasImageWithoutClass($record)) {
				$hasImageWithoutClass[] = $record->getId();
			}
    	}
    	$em = $this->getDoctrine()->getManager();
    	$em->flush();
    	return new Response($this->get('jms_serializer')->serialize($hasImageWithoutClass, 'json', SerializationContext::create()->setGroups(array('record.details'))));

    }


    private function hasImageWithoutClass($record) {
    	$crawler = new HtmlPageCrawler($record->getBody());

    	$images = $crawler->filter('img')->extract(array('class', 'src'));

    	foreach ($images as $key => $image) {
    		$fileName = $this->getFileName($image[1]);
    		$host = parse_url($image[1])['host'];
    		if( strlen((string)$image[0]) == 0 ) {
    			return true;
    		}

    	}
    	return false;
    }

    public function fixRecord($record) {
    	$record->setBody($this->getFixedBody($record));

    	$qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->createQueryBuilder('f');
    	$qb->where('f.fileName in (:fnames)')->setParameter('fnames', $this->getBodyImagesNames($record->getBody()));
    	$files = $qb->getQuery()->getResult();

    	$bodyImages = $record->getBodyImages();

    	if(count($bodyImages) != count($files)) {
    		foreach ($files as $key => $file) {
    			if(!$bodyImages->contains($file) && $file->getRecordAsBodyImage()->count() == 0) {
    				$record->addBodyImage($file);
    			}
    		}
    		if(!is_array($this->fixedRecords)) {
    			$this->fixedRecords = array();
    		}
    		$this->fixedRecords[] = $record->getRecordNumber();
    	}

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($record);

    	return $record;
    }

    private function getBodyImagesNames($body) {
    	$crawler = new HtmlPageCrawler($body);
    	$fileNames = [];
    	$imageUrls = $crawler
    		->filter('img')->extract(array('src'));
		foreach ($imageUrls as $key => $value) {
			$fileNames[] = $this->getFileName($value);
		}
		return $fileNames;
    }

    private function getFixedBody($record) {
    	return $this->addClassToImages($record->getBody());
    }

    private function addClassToImages($body) {
    	$crawler = new HtmlPageCrawler($body);
    	$crawler->filter('img')->each(function(HtmlPageCrawler $c, $i){
    		$fileName = $this->getFileName($c->attr('src'));
    		$c->attr('class', '');
    		$c->addClass(str_replace('.', '-', $fileName));
    	});

    	return $crawler->saveHTML();
    }

    private function getFileName($fileUrl) {
    	return(pathinfo($fileUrl)['basename']);
    }


    public function generateRecordRegistrationAction() {
        $em = $this->getDoctrine()->getManager();

        $recordRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $records = $recordRepo->findAll();

        $regCodes = [];

        foreach ($records as $key => $record) {
            $regCode = new \Darkish\CategoryBundle\Entity\RecordRegisterCode();
            $regCode->setCreated(new \Datetime());
            $regCode->setRecordNumber($record->getRecordNumber());
            $regCode->setUsername(rand(10000,99999).$record->getRecordNumber());
            $regCode->setPassword(rand(10000000, 99999999));

            $regCode->setUsed(false);

            $regCodes[] = $regCode;
        }







        // foreach ($regCodes as $entity) {
        //     $em->persist($entity);
        // }


        // $em->flush();

        return new Response($this->get('jms_serializer')->serialize($regCodes,'json'));
    }


	public function convertHtmlVideoTagAction() {
//		return new Response($this->replaceString('<video class="record-1438286741-44981-mp4" controls="" name="media" width="300"> <source src="http://178.62.236.24/n-darkish/web/uploads/video/record-1438286741-44981.mp4" type="video/mp4" /></video>'));
//			return new Response('convertHtmlVideoTag');
		$em = $this->getDoctrine()->getManager();
		$records = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->findAll();
		foreach($records as $record)
		{
			$record->setBody($this->replaceString($record->getBody()));
			$em->persist($record);
		}

		$news = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->findAll();
		foreach($news as $new)
		{
			$new->setBody($this->replaceString($new->getBody()));
			$em->persist($new);
		}

//		$record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find(409);
//
//		$body = $record->getBody();
//		return new Response($this->replaceString($body));

		$em->flush();
		return new Response('done');
	}

	private function replaceString($html)
	{
		$html = preg_replace("/\s+<source/", "<source", $html);
		$html = preg_replace("/\/><\/video>/", "></video>", $html);
		$html = preg_replace("/><source/", "", $html);
		$html = preg_replace("/<video/", "<dk-video", $html);
		$html = preg_replace("/<\/video/", "</dk-video", $html);

		//		$html = preg_replace("/\s+<source/", "<source", $html);
		$html = preg_replace("/\/><\/audio>/", "></audio>", $html);
//		$html = preg_replace("/><source/", "", $html);
		$html = preg_replace("/<audio/", "<dk-audio", $html);
		$html = preg_replace("/<\/audio/", "</dk-audio", $html);

//		$html2 = str_replace('/> <video>', '/><video>', $html);
//		$html3 = str_replace('/><video>', '><video>', $html2);
//		$html4 = str_replace('><source>', '', $html);
//		$html5 = str_replace('video', 'dk-video', $htm4);
		return $html;
	}


	public function changeGifImagesAction()
	{
		$gifFiles = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->findBy(['filemime' => 'image/gif']);

		$files = [];

		foreach($gifFiles as $file)
		{
			if($file->getType() == 'record')
			{
				$record = $file->getRecordAsBodyImage()->first();
				if($record instanceof Record)
				{
					$recordValue = $record->getId();
					$files[$file->getFileName()] = $recordValue;
				}

			}

			if($file->getType() == 'news')
			{
				$news = $file->getNewsAsBodyImage()->first();
				if($news instanceof News)
				{
					$newsValue = $news->getId();
					$files[$file->getFileName()] = $newsValue;
				}

			}


		}

		foreach($files as $fileName => $entity)
		{
			$gifFileName = substr($fileName, 0, strlen($fileName) -3) . 'gif';
//			$this->grab_image('http://178.62.236.24/n-darkish/web/uploads/image/'.$fileName, '/home/amir/Desktop/dkimages/'.$gifFileName);

		}


		return new JsonResponse($files);
	}

	function grab_image($url,$saveto){
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw=curl_exec($ch);
		curl_close ($ch);
		if(file_exists($saveto)){
			unlink($saveto);
		}
		$fp = fopen($saveto,'x');
		fwrite($fp, $raw);
		fclose($fp);
	}

}
