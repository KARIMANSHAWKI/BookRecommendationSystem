<?php

namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\ISectionManagementService;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SectionManagementController extends Controller
{
    public function __construct(private ISectionManagementService $sectionManagementService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('view sections');
        $sections = $this->sectionManagementService->list(request('per_page', 15));
        return SectionResource::collection($sections)->additional(['meta' => [
            'current_page' => $sections->currentPage(),
            'last_page' => $sections->lastPage(),
            'total' => $sections->total(),
        ]]);
    }

    public function show(Section $section): SectionResource
    {
        $this->authorize('view sections');

        return SectionResource::make($this->sectionManagementService->get($section));
    }

    public function store(SectionStoreRequest $req): JsonResponse
    {
        $section = $this->sectionManagementService->create($req->validated());
        return SectionResource::make($section)->response()->setStatusCode(201);
    }

    public function update(SectionUpdateRequest $req, Section $section): SectionResource
    {
        return SectionResource::make($this->sectionManagementService->update($section, $req->validated()));
    }

    public function destroy(Section $section): JsonResponse
    {
        $this->authorize('delete sections', $section);
        $this->sectionManagementService->delete($section);
        return response()->json(null, 204);
    }
}
