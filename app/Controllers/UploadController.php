<?php

namespace App\Controllers;



use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\UploadedFile;
use Slim\Views\Twig;


class UploadController
{

    public function __construct(private readonly Twig $twig)
    {
    }

    public function index(Request $request, Response $response, $args): Response
    {
        return $this->twig->render($response, 'uploadFile.twig');
    }


    public function store(Request $request, Response $response)
    {
        //todo move all to service
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';

        $saveFilePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];
        move_uploaded_file($_FILES['receipt']['tmp_name'], $saveFilePath);

        echo '<pre>';
        $saveFilePath;
        echo '</pre>';

        // todo replace php stuff with $requests etc
        $uploadedFiles = $request->getUploadedFiles();
        var_dump($uploadedFiles);

        $body = $response->getBody();
        $body->write("File uploaded");
        return $response->withBody($body);
    }

    //todo move to file microservice
    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }


    public function update(): void
    {

    }
}