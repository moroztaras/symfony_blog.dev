<?php

namespace FileBundle\Controller;

use CoreBundle\CoreBundle;
use FileBundle\Core\FileManager;
use FileBundle\Forms\Form\FileUploadForm;
use FileBundle\Forms\Model\FileUploadFileModel;
use FileBundle\Forms\Model\FileUploadModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FileController extends Controller
{
    public function loadFileAction(Request $request)
    {
        $model = new FileUploadModel([],'trash');
        $form = $this->createForm(FileUploadForm::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = CoreBundle::service('file.manager')->prepareUploadFile($model);
            /*
             * @var $em EntityManager
             */
            $em = CoreBundle::service('doctrine.orm.entity_manager');
            $em->persist($file);
            $em->flush();
        }

        return $this->render(
            'FileBundle:file:file.html.twig',[
                'form' => $form->createView()
            ]);
    }
}