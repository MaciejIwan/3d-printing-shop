<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\PrintingModel;
use App\Repository\PrintingModelRepository;
use Slim\Psr7\UploadedFile;

class FilesUploadService
{
    private string $saveFilePath = STORAGE_PATH . '/3dModels/';

    public function __construct(private readonly PrintingModelRepository $printingModelRepository)
    {

    }

    public function handleNewFile(mixed $modelFile): void
    {

        $new_name = $this->moveUploadedFile($this->saveFilePath, $modelFile);

        $printingModel = new PrintingModel();
        $printingModel
            ->setFilename($new_name)
            ->setMaterialCost(1);
        $this->printingModelRepository->add($printingModel);
    }

    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(16));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}