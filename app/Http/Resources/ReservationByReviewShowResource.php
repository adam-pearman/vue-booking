<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationByReviewShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'reservation_id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'booking' => new ReservationByReviewBookingShowResource($this->booking),
        ];
    }
}
