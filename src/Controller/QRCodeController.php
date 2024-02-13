<?php

/*namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QRCodeController extends AbstractController
{
    #[Route('/q/r/code', name: 'app_q_r_code')]
    public function index(): Response
    {
        return $this->render('qr_code/index.html.twig', [
            'controller_name' => 'QRCodeController',
        ]);
    }
}*/
// src/Controller/QRCodeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use BaconQrCode\Encoder\QrCode as BaconQrCode;
use BaconQrCode\Renderer\Image\Png as BaconPngRenderer;
use App\Entity\Commandes;
use App\Service\QrCodeService;

class QRCodeController extends AbstractController
{
    #[Route('/qrcode/{id}', name: 'qrcode')]
    #[ParamConverter("commande", class:"App\Entity\Commandes")]
    public function generateQRCode(Commandes $commande, QrCodeService $qrCodeService): Response 
    {
        $clefinale = $commande->getQrCode();
        // Utilisez le service pour générer le QR code à partir des données spécifiées
        $qrCodeData = $qrCodeService->generateQrCode($clefinale);

        // Créez une réponse avec les données du QR code et définissez le type de contenu
        $response = new Response($qrCodeData);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}

