<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfService
{
    private HttpClientInterface $client;
    private string $microserviceUrl;

    public function __construct(string $microserviceUrl)
    {
        $this->client = HttpClient::create();
        $this->microserviceUrl = $microserviceUrl;
    }

    public function generatePdf(string $url): ?string
    {   
        try {
            $response = $this->client->request(
                'POST', 
                $this->microserviceUrl . '/api/convert/pdf',
                [
                    'json' => ['url' => $url]
                ]
            );
    
            if ($response->getStatusCode() !== 200) {
                $errorContent = $response->getContent(false);
                throw new \Exception('Error response from PDF microservice: ' . $errorContent);
            }
    
            $pdfContent = $response->getContent();
            return $pdfContent;

        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return null;
        }
    }
}
