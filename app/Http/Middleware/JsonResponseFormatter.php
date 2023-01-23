<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JsonResponseFormatter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->expectsJson()) {
            $this->responseFormatting($response);
        }

        return $response;
    }

    /**
     * @param  JsonResponse|Response  $response
     */
    private function responseFormatting($response): void
    {
        $data = [
            'message' => $this->getMessageByResponse($response),
        ];
        $this->setResultByResponse($response, $data);
        $response->setContent(json_encode($data));
    }

    /**
     * @param  JsonResponse|Response  $response
     * @SuppressWarnings(PHPMD.UndefinedVariable)
     * @return string
     */
    private function getMessageByResponse($response): string
    {
        if ($this->isValidationFailed($response)) {
            return $response->original['message'];
        }

        return Response::$statusTexts[$response->getStatusCode()] ?? '';
    }

    /**
     * @param  JsonResponse|Response  $response
     * @param  array  $data
     * @return mixed
     */
    private function setResultByResponse($response, array &$data): void
    {
        if ($this->isValidationFailed($response)) {
            $data['result'] = $response->original['errors'];

            return;
        }
        $result = json_decode($response->getContent(), true);
        if (json_last_error() == JSON_ERROR_NONE) {
            $data['result'] = $result['resource_data'] ?? $result;
            if ($this->hasPagination($result)) {
                $data['_meta'] = [
                    'pagination' => [
                        'totalCount' => (int)$result['meta']['total'],
                        'pageCount' => (int)$result['meta']['last_page'],
                        'currentPage' => (int)$result['meta']['current_page'],
                        'perPage' => (int)$result['meta']['per_page'],
                    ],
                ];
                unset($result['link'], $result['meta']);
            }

            return;
        }
        $data['result'] = $response->getContent();
    }

    /**
     * @param  JsonResponse|Response  $response
     * @return bool
     */
    private function isValidationFailed($response): bool
    {
        return $response->status() === 422 && isset($response->original['errors'], $response->original['message']);
    }

    private function hasPagination($data): bool
    {
        return isset($data['meta']['total']);
    }
}
