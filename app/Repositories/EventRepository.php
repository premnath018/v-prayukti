<?php

namespace App\Repositories;

use App\Models\Event;
use App\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    public function index()
    {
        return Event::select('id','name','image_url','type')->get();
    }

    public function getById($id)
    {
        return Event::findOrFail($id);
    }

    public function store(array $data)
    {
        return Event::create($data);
    }

    public function update(array $data, $id)
    {
        return Event::whereId($id)->update($data);
    }

    public function delete($id)
    {
        return Event::destroy($id);
    }
}
