<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'name' => $this->name,
            'email' => $this->email,
            'github_logged_in_at' => $this->github_logged_in_at,
            'github_registered_at' => $this->github_registered_at,
            'vkontakte_logged_in_at' => $this->vkontakte_logged_in_at,
            'vkontakte_registered_at' => $this->vkontakte_registered_at,
            'app_logged_in_at' => $this->app_logged_in_at,
            'app_registered_at' => $this->app_registered_at,
        ];
    }
}
