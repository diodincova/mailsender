<?php
namespace App\Application\Service\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response extends JsonResponse
{
    const API_CONTENT_TYPE = 'application/json';

    public function __construct($data, int $status = self::HTTP_OK, array $headers = [], bool $json = false)
    {
        $headers['Content-Type'] = self::API_CONTENT_TYPE;

        parent::__construct($data, $status, $headers, $json);
    }
}