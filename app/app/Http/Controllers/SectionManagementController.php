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
   public function __construct(private ISectionManagementService $svc)
   {
      $this->middleware('auth:sanctum');
      $this->middleware('can:view sections,App\Models\Section')->only(['index','show']);
      $this->middleware('can:create sections,App\Models\Section')->only('store');
      $this->middleware('can:edit sections,section')->only('update');
      $this->middleware('can:delete sections,section')->only('destroy');
   }

   public function index(): AnonymousResourceCollection
   {
       $sections = $this->svc->list(request('per_page', 15));
       return SectionResource::collection($sections)
                ->additional(['meta' => [
                    'current_page' => $sections->currentPage(),
                    'last_page'    => $sections->lastPage(),
                    'total'        => $sections->total(),
       ]]);
   }

   public function show(Section $section): SectionResource
   {
      return SectionResource::make($this->svc->get($section));
   }

   public function store(SectionStoreRequest $req): JsonResponse
   {
       $section = $this->svc->create($req->validated());
       return SectionResource::make($section)->response()->setStatusCode(201);
   }

   public function update(SectionUpdateRequest $req, Section $section): SectionResource
   {
       return SectionResource::make($this->svc->update($section, $req->validated()));
   }

   public function destroy(Section $section): JsonResponse
   {
      $this->svc->delete($section);
      return response()->json(null, 204);
   }
}
