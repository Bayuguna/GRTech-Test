@extends('handler.layout')

@section('content')
    <section class="flex items-center h-full p-16 dark:bg-gray-50 dark:text-gray-800">
        <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
            <div class="max-w-md text-center">
                <h2 class="mb-8 font-extrabold text-9xl dark:text-gray-400">
                    <span class="sr-only">Error</span>403
                </h2>
                <p class="text-2xl font-semibold md:text-3xl">Oops, you are not allowed to access this page.</p>
                <p class="mt-4 mb-8 dark:text-gray-600">But dont worry, you can find plenty of other things on our homepage.
                </p>
                <a rel="noopener noreferrer" href="{{ route('dashboard') }}"
                    class="px-8 py-3 font-semibold rounded btn btn-success">Back to
                    homepage</a>
            </div>
        </div>
    </section>
@endsection
