<?php

namespace App\Application\Service\Rest;


class ResponseFactory
{
    /**
     * @param $data
     * @param int $status
     * @return Response
     * @throws \Exception
     */
    private function createJsonResponse($data, $status = Response::HTTP_OK): Response
    {
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception(json_last_error_msg());
        }

        return Response::fromJsonString(
            json_encode($json_data),
            $status,
            [
                'Content-Type' => Response::API_CONTENT_TYPE,
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST',
                'Access-Control-Allow-Headers' => 'Accept, Content-Type'
            ]
        );
    }

    /**
     * @param $data
     * @param int $status
     * @return Response
     * @throws \Exception
     */
    public function createResponse($data, $status = Response::HTTP_OK): Response
    {
        $response['data'] = $data;

        return $this->createJsonResponse($response, $status);
    }
}