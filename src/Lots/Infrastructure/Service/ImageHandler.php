<?php

namespace App\Lots\Infrastructure\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageHandler extends AbstractController
{
    public function handle(UploadedFile $file): string
    {
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads/';
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = uniqid().'-'.Urlizer::urlize($originalFilename).'.'.$file->guessExtension();
        $file->move($destination, $newFileName);

        return $newFileName;
    }
}
