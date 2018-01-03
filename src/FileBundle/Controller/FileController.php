<?php

namespace FileBundle\Controller;

use CoreBundle\CoreBundle;
use FileBundle\Core\FileManager;
use FileBundle\Forms\Form\FileUploadForm;
use FileBundle\Forms\Model\FileUploadFileModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FileController extends Controller
{
    public function loadFileAction(Request $request)
    {
        var_dump(FileManager::uploadFolderDir());
        $model = new FileUploadFileModel();
        $form = $this->createForm(FileUploadForm::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            var_dump("Все ОК!");
        }

        return $this->render(
            'FileBundle:file:file.html.twig',[
                'form' => $form->createView()
            ]);
    }
}