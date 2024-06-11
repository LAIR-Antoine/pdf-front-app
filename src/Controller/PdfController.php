<?php

namespace App\Controller;

use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PdfController extends AbstractController
{
    private PdfService $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    #[Route('/generate-example-pdf', name: 'generate_pdf', methods: ['GET', 'POST'])]
    public function generatePdf(): Response
    {
        $url = 'https://sparksuite.github.io/simple-html-invoice-template/';

        try {
            $pdfContent = $this->pdfService->generatePdf($url);
            return new Response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), 500);
        }
    }

    #[Route('/generate-pdf', name: 'generate_pdf', methods: ['GET', 'POST'])]
    public function generate(): Response
    {
        return $this->render('pdf/generate.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }
}
