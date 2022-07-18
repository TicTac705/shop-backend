<?php
namespace App\Dto;

use App\Http\Requests\ImageCreationRequest;

class ImageCreateDto extends BaseDto
{
    /** @var \Illuminate\Http\UploadedFile[] */
    public array $images;

    public function fromRequest(ImageCreationRequest $request): self
    {
        return new self([
            'images' => $request->file('images'),
        ]);
    }
}
