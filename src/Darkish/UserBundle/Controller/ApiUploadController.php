<?php

namespace Darkish\UserBundle\Controller;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Oneup\UploaderBundle\Controller\AbstractController;
use Oneup\UploaderBundle\Uploader\Response\EmptyResponse;

class ApiUploadController extends AbstractController
{
    public function upload()
    {
        // get some basic stuff together
        $request = $this->container->get('request');

        $response = new EmptyResponse();

        // get file from request (your own logic)
        $file = $request->files->get('file');

        try {
            $this->handleUpload($file, $response, $request);
        } catch(UploadException $e) {
            // return nothing
            return new JsonResponse(array());
        }

        // return assembled response
        return new JsonResponse($response->assemble());
    }
}

