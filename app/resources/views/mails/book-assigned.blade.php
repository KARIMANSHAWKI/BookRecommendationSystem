@component('mail::message')
    # Congratulations, {{ $publisher->name }}! 🎉

    Your book **{{ $book->name }}** has been added to the **{{ $section->name }}** section.

    - **Book ID:** {{ $book->id }}
    - **Pages:** {{ $book->number_of_pages }}
    - **Description:** {{ \Illuminate\Support\Str::limit($book->description, 140) }}

    @component('mail::button', ['url' => $viewUrl])
        View Book
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
