<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

abstract class ApiService
{
    /**
     * Tự động thêm authorization token từ session vào http client.
     */
    protected function http()
    {
        return Http::baseUrl(config('services.api.base_url', 'http://localhost:8080'))
            ->withToken(session('admin_token', ''))
            ->acceptJson();
    }

    protected function handleResponse($response, $method, $endpoint)
    {
        if ($response->failed()) {
            Log::error("API $method error on $endpoint", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new Exception("API error");
        }
        return $response->json();
    }

    protected function get($endpoint, $params = [])
    {
        $response = $this->http()->get($endpoint, $params);
        return $this->handleResponse($response, 'GET', $endpoint);
    }

    protected function post($endpoint, $data = [])
    {
        \Illuminate\Support\Facades\Log::info("API POST payload to $endpoint: " . json_encode($data));
        $response = $this->http()->post($endpoint, $data);
        return $this->handleResponse($response, 'POST', $endpoint);
    }

    protected function put($endpoint, $data = [])
    {
        $response = $this->http()->put($endpoint, $data);
        return $this->handleResponse($response, 'PUT', $endpoint);
    }

    protected function patch($endpoint, $data = [])
    {
        $response = $this->http()->patch($endpoint, $data);
        return $this->handleResponse($response, 'PATCH', $endpoint);
    }

    protected function deleteReq($endpoint, $data = [])
    {
        $response = $this->http()->delete($endpoint, $data);
        return $this->handleResponse($response, 'DELETE', $endpoint);
    }
}
