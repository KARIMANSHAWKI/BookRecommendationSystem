@component('mail::message')
    # New Book Added

    **{{ $publisher->name }}** just created a new book:

    - **ID:** {{ $book->id }}
    - **Name:** {{ $book->name }}
    - **Pages:** {{ $book->number_of_pages }}
    - **Description:** {{ \Illuminate\Support\Str::limit($book->description, 140) }}

    @component('mail::button', ['url' => $assignUrl])
        Assign this Book to a Section
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
