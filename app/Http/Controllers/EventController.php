<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $data = $this->eventRepository->index();
        return ApiResponseClass::sendResponse(EventResource::collection($data), '', 200);
    }

    public function store(StoreEventRequest $request)
    {
        DB::beginTransaction();
        try {
            $event = $this->eventRepository->store($request->all());
            DB::commit();
            return ApiResponseClass::sendResponse(new EventResource($event), 'Event created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseClass::rollback($e);
        }
    }

    public function show($id)
    {
        $event = $this->eventRepository->getById($id);
        return ApiResponseClass::sendResponse(new EventResource($event), '', 200);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->eventRepository->update($request->all(), $id);
            DB::commit();
            return ApiResponseClass::sendResponse('Event updated successfully.', '', 200);
        } catch (\Exception $e) {
            return ApiResponseClass::rollback($e);
        }
    }

    public function destroy($id)
    {
        $this->eventRepository->delete($id);
        return ApiResponseClass::sendResponse('Event deleted successfully.', '', 204);
    }
}
