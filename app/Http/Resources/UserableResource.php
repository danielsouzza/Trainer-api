<?php

namespace App\Http\Resources;

use App\Models\PersonalTrainer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'name' => $this['userable']->name,
            'description' => $this['userable']->description,
            'birthday' => $this['userable']->birthday,
            'image' => $this['userable']->image,
            'userable_type' => $this->userable_type,
            'userable_id' => $this['userable']->id
        ];
        if (str_contains($this->userable_type,'Personal')){
            $resource['institution'] = $this['userable']->instituicao;
            $resource['cref'] = $this['userable']->cref;
            $resource['graduation_year'] = $this['userable']->graduation_year;

        }
        return $resource;
    }
}
