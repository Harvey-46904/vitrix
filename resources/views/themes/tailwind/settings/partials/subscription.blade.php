<div class="p-8">
    @if(auth()->user()->hasRole('admin'))
        <p class="text-light">Este usuario es un usuario administrador y, por lo tanto, no necesita una suscripción</p>
    @else
        @if(auth()->user()->subscriber())
            <div class="flex flex-col">
                <h5 class="mb-2 text-xl font-bold text-gray-700">Modify Payment Information</h5>
                <p>Click the button below to update your default payment method</p>
                <a href="{{ auth()->user()->subscription->update_url }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md checkout-update bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">Update Payment Info</a>
            </div>

            <hr class="my-8 border-gray-200">

            <div class="flex flex-col">
                <h5 class="mb-2 text-xl font-bold text-gray-700">Danger Zone</h5>
                <p class="text-red-400">Click the button below to cancel your subscription.</p>
                <p class="text-xs">Note: Your account will be immediately downgraded.</p>
                <button onclick="cancelClicked()" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-500 border border-transparent rounded-md hover:bg-red-600 focus:outline-none focus:border-red-600 focus:shadow-outline-red-500 active:bg-red-600">Cancel Subscription</button>
            </div>

	        @include('theme::partials.cancel-modal')
        @else
            <p class="text-gray-600 text-light">Suscríbase a un plan para ver la información de su suscripción.</p>
            <a href="{{ route('wave.settings', 'plans') }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">Mirar Planes</a>
        @endif
    @endif
</div>
<script>
	window.cancelClicked = function(){
		Alpine.store('confirmCancel').openModal();
	}
</script>
