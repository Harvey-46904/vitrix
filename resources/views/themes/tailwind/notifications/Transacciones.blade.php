@extends('theme::layouts.app')


@section('content')

<div class="max-w-4xl px-5 mx-auto mt-10 lg:px-0">
	<a href="{{ route('wave.dashboard') }}"
		class="flex items-center mb-6 font-mono text-sm font-bold leading-tight cursor-pointer text-wave-500">
		<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
			</path>
		</svg>
		Regresar a la dashboard
	</a>
</div>

<div class="max-w-4xl px-5 mx-auto mt-10 lg:px-0">



	<h1 class="flex items-center text-3xl font-bold text-gray-700 text-light">
		<svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
			</path>
		</svg>
		Todas las transacciones
	</h1>
	<div class="uk-align-center">
		<div class="bg-white rounded-md border border-gray-100 my-4"
			role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
			@if (!$transacciones->isNotEmpty())
			<div id="notifications-none" class=" bg-gray-150 flex items-center justify-center h-24 w-full text-gray-600 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                No tienes transacciones en este momento!
            </div>
			@else
			<div class="relative">
				<table class="table table-striped">
					<thead>
					  <tr>
						<th scope="col">#</th>
						<th scope="col">Razón</th>
						<th scope="col">Monto</th>
						<th scope="col">Fecha</th>
					  </tr>
					</thead>
					<tbody>
						@foreach ($transacciones as $item)
						<tr>
							<th scope="row">{{ $loop->iteration }}</th> <!-- Muestra el índice -->
							<td>{{$item->type}}</td>
							<td>{{$item->amount}}</td>
							<td>{{$item->created_at}}</td>
						  </tr>
						@endforeach
					
					 
					</tbody>
				  </table>
			</div>
			@endif
			

			
		</div>
	</div>

</div>

@endsection