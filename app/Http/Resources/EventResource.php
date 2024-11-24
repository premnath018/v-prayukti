<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'image_url' => $this->image_url,
            'form_url' => $this->form_url,
            'type' => $this->type,
            'rulebook_url' => $this->rulebook_url,
            'domain' => $this->domain,
            'tag' => $this->tag,
            'fee' => $this->fee,
            'deadline' => $this->deadline,
            'team_count' => $this->team_count,
            'team_formation' => $this->team_formation,
            'problem_url' => $this->problem_url,
            'introduction' => $this->introduction,
            'description' => $this->description,
            'info' => $this->info,
            'eligibility' => $this->eligibility,
            'faculty_contacts' => $this->faculty_contacts,
            'student_contacts' => $this->student_contacts,
            'contact_email' => $this->contact_email,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
