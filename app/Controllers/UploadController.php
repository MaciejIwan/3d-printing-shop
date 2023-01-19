<?php

namespace App\Controllers;


use App\Entity\User;
use App\Services\FilesUploadService;
use Exception;
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


    public function download(Request $request, Response $response, array $args)
    {
        //todo in the future we should check permission to files
        $filename = $args['filename'];

        if (!preg_match('/^[\w0-9_.-]+$/', $filename)) {
            return $response->withStatus(404);
        }

        $filepath = STL_MODELS_PATH . $filename;
        if (!file_exists($filepath)) {
            return $response->withStatus(404);
        }

        try {
            $response = $response->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename="' . basename($filepath) . '"')
                ->withHeader('Content-Length', filesize($filepath));
            $response->getBody()->write(file_get_contents($filepath));
            return $response;
        } catch (Exception $e) {
            return $response->withStatus(500);
        }
    }


}
