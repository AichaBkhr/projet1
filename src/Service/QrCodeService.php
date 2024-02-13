<?php
namespace App\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;

class QrCodeService
{
    public function generateQrCode(string $content): string
    {
        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($content)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            //->logoPath(__DIR__.'/../../public/assets/images/Logo.png')
            //->logoResizeToWidth(50)
            //->logoPunchoutBackground(true)
            ->labelText('Votre e-billet')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        // Récupérer les données de l'image générée sous forme de chaîne
        return $result->getString();
    }
}
