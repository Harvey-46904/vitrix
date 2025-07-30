@extends('theme::layouts.app')

@section('content')

    <div class="max-w-4xl px-5 mx-auto mt-10 lg:px-0">
        <a href="{{ route('wave.announcements') }}" class="flex items-center mb-6 font-mono text-sm font-bold cursor-pointer text-wave-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Mirar Todos Los Anuncios
        </a>
    </div>

    <article id="announcement-{{ $announcement->id }}" class="max-w-4xl px-5 pb-20 mx-auto prose prose-xl lg:prose-2xl lg:px-0 bg-gris neon-shadow p-4 mb-2">

        <meta property="name" content="{{ $announcement->title }}">
        <meta property="author" typeof="Person" content="admin">
        <meta property="dateModified" content="{{ Carbon\Carbon::parse($announcement->updated_at)->toIso8601String() }}">
        <meta class="uk-margin-remove-adjacent" property="datePublished" content="{{ Carbon\Carbon::parse($announcement->created_at)->toIso8601String() }}">

        <div class="max-w-4xl mx-auto mt-6">
            <h1 class="flex flex-col leading-none">
                <h1 class="display-4 gamers texturizado-warning"> {{ $announcement->title }}</h1>
                <span class="mt-0 mt-10 text-base font-normal text-light">Publicado <time datetime="{{ Carbon\Carbon::parse($announcement->created_at)->toIso8601String() }}">{{ Carbon\Carbon::parse($announcement->created_at)->toFormattedDateString() }}</time>. </span>
            </h1>
        </div>

        <div class="max-w-4xl mx-auto text-light">
            {!! $announcement->body !!}
        </div>

    </article>

@endsection
