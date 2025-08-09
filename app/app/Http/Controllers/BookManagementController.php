<?php
namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\IBookManagementService;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Jobs\SendBookAssignedMailJob;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Models\Book;
use App\Http\Requests\AssignBookSectionRequest;
use App\Jobs\NotifySectionManagersAboutNewBookJob;
use Illuminate\Support\Facades\Mail;
use App\Mails\BookAssignedToSectionMail;
use App\Events\BookCreated;
use App\Events\BookSectionAssigned;

class BookManagementController extends Controller
{
    public function __construct(private IBookManagementService $svc)
    {
        $this->middleware('auth:sanctum')->except(['index','show']);

        // checks “does the user have the spatie permission ‘edit books’?”
        $this->middleware('can:edit books,book')->only('update');
        $this->middleware('can:create books,App\Models\Book')->only('store');
        $this->middleware('can:delete books,book')->only('destroy');

        // who can attach/detach a section?
        $this->middleware('can:assign books,book')->only('assignSection');
    }

    public function index(): AnonymousResourceCollection
    {
        $books = $this->svc->list(request('per_page', 15));

        return BookResource::collection($books)
                ->additional([
                    'meta' => [
                        'current_page' => $books->currentPage(),
                        'last_page'    => $books->lastPage(),
                        'total'        => $books->total(),
                    ]
                ]);
    }

    public function show(Book $book): BookResource
    {
        return BookResource::make($this->svc->get($book));
    }

    public function store(BookStoreRequest $req): JsonResponse
    {
        $data = $req->validated();
        $data['created_by'] = auth()->id();   // <- who created it

        $book = $this->svc->create($data);

        // optional: only notify if creator is a publisher
        // if (auth()->user()->hasRole('publisher')) {
        //     dispatch(new NotifySectionManagersAboutNewBookJob(auth()->user(), $book));
        // }

//        dispatch(new NotifySectionManagersAboutNewBookJob(auth()->user(), $book));
        // Fire the event (listeners are queued automatically via ShouldQueue)
        event(new BookCreated(auth()->user(), $book));
        return BookResource::make($book)
                ->response()
                ->setStatusCode(201);
    }

    public function update(BookUpdateRequest $req, Book $book): BookResource
    {
       return BookResource::make(
                $this->svc->update($book, $req->validated())
       );
    }

    public function destroy(Book $book): JsonResponse
    {
       $this->svc->delete($book);
       return response()->json(null, 204);
    }
    public function assignSection(AssignBookSectionRequest $req, Book $book): BookResource
    {
        //api/books/8/section
       // section_id:2
        $book->section()->associate($req->validated('section_id')); // null removes
        $book->save();
//        $book->load('section','publisher');

            // queue it (works if your queue worker is running), or use ->send(...) while debugging
            //Mail::to($book->publisher->email)->queue(new BookAssignedToSectionMail($book));
            // Mail::to($book->publisher->email)->send(new BookAssignedToSectionMail($book)); // debug sync
           // SendBookAssignedMailJob::dispatch($book);
        event(new BookSectionAssigned($book, auth()->user()));
        //enhance message
        return BookResource::make($book->load('section'));
    }
}
