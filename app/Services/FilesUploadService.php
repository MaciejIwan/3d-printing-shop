<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\PrintingModel;
use App\Exceptions\UnsupportedFileExtension;
use App\Repository\PrintingModelRepository;
use PHPSTL\Handler\VolumeHandler;
use PHPSTL\Reader\STLReader;
use Slim\Psr7\UploadedFile;

require __DIR__ . '/../../configs/printingConst.php';

class FilesUploadService
{
    //private string $saveFilePath = STORAGE_PATH . '/3dModels/';

    public function __construct(private readonly PrintingModelRepository $printingModelRepository)
    {

    }

    public function handleNewFile(mixed $modelFile): PrintingModel
    {
        $userFilename = $modelFile->getClientFilename();
        $file_extension = pathinfo($userFilename, PATHINFO_EXTENSION);

        if (strcasecmp($file_extension, SUPPORTED_FILES_EXTENSION)) {
            throw new UnsupportedFileExtension();
        }

        $new_name = $this->moveUploadedFile($modelFile);
        $materialCost = $this->calcMaterialPrice($new_name);


        $printingModel = new PrintingModel();
        $printingModel
            ->setOriginalName($userFilename)
            ->setFilename($new_name)
            ->setMaterialCost($materialCost)
            ->setPrice($this->calcPrice($materialCost, MARGIN));
        $this->printingModelRepository->add($printingModel);
        return $printingModel;
    }

    private function moveUploadedFile(UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(16));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo(STL_MODELS_PATH . $filename);

        return $filename;
    }

    public function calcMaterialPrice(string $new_name): float
    {
        //todo in future we need to check cost, and price for client seperatly. To calc margin

        $reader = STLReader::forFile(STL_MODELS_PATH . $new_name);
        $reader->setHandler(new VolumeHandler());

        $volume = $reader->readModel();
        $grams = $volume / 1000;

        // todo we can print in many filaments so filamentPrice/g should be passed as arg
        return $grams * FILAMENT_PRICE_PER_GRAM;
    }

    public function calcPrice(float $price, float $margin): float
    {
        return ($price * $margin > MIN_PRINT_COST) ? $price * $margin : MIN_PRINT_COST;
    }
}
