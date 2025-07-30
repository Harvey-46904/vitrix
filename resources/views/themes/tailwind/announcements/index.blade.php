@extends('theme::layouts.app')

@section('content')
    <div class="container  neon-shadow py-2 my-2 ">
        <div class="max-w-4xl px-5 pb-20 mx-auto prose prose-xl lg:prose-2xl lg:px-0">

	<div class="row ">
		<div class="col-md-12 text-center  py-3">
			<h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl"
				data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>
				ANUNCIOS VITRIX</h1>

			

		</div>
	</div>


        <div class="pb-8 my-8 border-b border-gray-200">

            @foreach($announcements as $announcement)

                <a href="{{ route('wave.announcement', $announcement->id) }}" class="text-light">{{ $announcement->title }}</a>
                

            @endforeach

        </div>

    </div>
    </div>
    
    
    

@endsection