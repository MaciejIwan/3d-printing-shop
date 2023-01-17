<?php

namespace App\Controllers;


use App\Services\FilesUploadService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class UploadController
{

    public function __construct(
        private readonly Twig               $twig,
        private readonly FilesUploadService $filesUploadService
    )
    {
    }

    public function index(Request $request, Response $response, $args): Response
    {
        return $this->twig->render($response, 'uploadFile.twig');
    }


    public function store(Request $request, Response $response)
    {
        $modelFile = $request->getUploadedFiles()['model_file'];

        $printingModel = $this->filesUploadService->handleNewFile($modelFile);

//        $body = $response->getBody();
//        $body->write("File uploaded. Cost is " . $printingModel->getPrice() . " PLN");

        return $this->twig->render(
            $response,
            'pricePreview.twig',
            [
                'printingModel' => $printingModel,
            ]
        );
    }


    public function update(): void
    {

    }


}
