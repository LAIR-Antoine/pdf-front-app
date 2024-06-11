<?php

namespace App\Controller;

use App\Service\PdfService;
use App\Entity\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Doctrine\ORM\EntityManagerInterface;

class PdfController extends AbstractController
{
    private PdfService $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    #[Route('/generate-example-pdf', name: 'generate_example_pdf', methods: ['GET', 'POST'])]
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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('pdf/generate.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }

    #[Route('/generated-pdf', name: 'generate_pdf_from_url', methods: ['POST'])]
    public function generatePdfFromUrl(Request $request, EntityManagerInterface $manager): Response
    {
        $url = $request->request->get('url');

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        try {
            $pdfContent = $this->pdfService->generatePdf($url);

            // Save PDF to uploads/pdf directory
            $pdfFilename = 'pdf-' . time() . '.pdf';
            $pdfPath = $this->getParameter('kernel.project_dir') . '/public/uploads/pdf/' . $pdfFilename;
            file_put_contents($pdfPath, $pdfContent);

            $pdf = new Pdf();
            $pdf->setUser($this->getUser());
            $pdf->setTitle($pdfFilename);
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($pdf);
            $manager->flush();

            // Redirect to preview page
            return $this->redirectToRoute('preview_pdf', [
                'pdfFilename' => $pdfFilename
            ]);

        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), 500);
        }
    }

    #[Route('/preview-pdf/{pdfFilename}', name: 'preview_pdf', methods: ['GET'])]
    public function previewPdf(string $pdfFilename): Response
    {
        $pdfPath = 'uploads/pdf/' . $pdfFilename;

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('pdf/preview.html.twig', [
            'pdfFilename' => $pdfFilename,
            'pdfPath' => $pdfPath,
            'controller_name' => 'PdfController',
        ]);
    }

    #[Route('/download-pdf/{pdfFilename}', name: 'download_pdf', methods: ['GET'])]
    public function downloadPdf(string $pdfFilename): Response
    {
        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/uploads/pdf/' . $pdfFilename;

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->file($pdfPath, $pdfFilename, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }

}
