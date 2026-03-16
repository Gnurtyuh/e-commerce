<?php
namespace App\Services;

class ImageApiService extends ApiService
{
    public function getByProduct($productId)
    {
        return $this->get("/products/{$productId}/images");
    }

    public function upload($productId, $imagePath, $isMain = false, $sortOrder = 0)
    {
        try {
            $endpoint = "/products/{$productId}/images";
            $response = $this->post($endpoint, [
                'imagePath' => $imagePath,
                'isMain' => $isMain,
                'sortOrder' => $sortOrder,
            ]);
            return $response;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Image upload failed: " . $e->getMessage());
            return ['success' => false];
        }
    }

    public function setMain($imageId)
    {
        return $this->patch("/products/images/{$imageId}/main");
    }

    public function deleteImage($imageId)
    {
        return $this->deleteReq("/products/images/{$imageId}");
    }
}

