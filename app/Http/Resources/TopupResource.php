<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'inv_no' => $this->inv_no,
            'total' => rupiah($this->total),
            'status' => $this->status,
            'payment_token' => $this->payment_token,
            'created_at' => tgltime($this->created_at),
        ];
    }
}
