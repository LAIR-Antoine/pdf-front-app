<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    private HttpClientInterface $client;
    private string $gotenbergUrl;

    public function __construct(string $gotenbergUrl)
    {
        $this->client = HttpClient::create();
        $this->gotenbergUrl = $gotenbergUrl;
    }

    public function generatePdf(string $url): string
    {
        $response = $this->client->request('POST', $this->gotenbergUrl . '/forms/chromium/convert/url', [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'body' => [
                'url' => $url,
            ],
        ]);
        //var_dump($htmlContent);

        if ($response->getStatusCode() !== 200) {
            // Capture the response content even if it's an error
            $errorContent = $response->getContent(false);
            throw new \Exception('Error generating PDF: ' . $errorContent);
        }

        return $response->getContent();
    }
}
