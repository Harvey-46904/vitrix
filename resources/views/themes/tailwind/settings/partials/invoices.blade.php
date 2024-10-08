<div class="p-8">

	@subscriber
        @php
            $subscription = new \Wave\Http\Controllers\SubscriptionController;
            $transactions = $subscription->transactions( auth()->user() );
        @endphp



        @if(count($transactions) > 0)

            <table class="min-w-full overflow-hidden divide-y divide-gray-200 rounded-lg">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-100">
                            Date of Invoice
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-right text-gray-500 uppercase bg-gray-100">
                            Price
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-right text-gray-500 uppercase bg-gray-100">
                            Receipt Link
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="@if($loop->index%2 == 0){{ 'bg-gray-50' }}@else{{ 'bg-gray-100' }}@endif">
                            <td class="px-6 py-4 text-sm font-medium leading-5 text-gray-900 whitespace-no-wrap">
                                {{ Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium leading-5 text-right text-gray-900 whitespace-no-wrap">
                                {{ $transaction->details->totals->subtotal }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap">
                                <a href="/settings/invoices/{{ $transaction->id }}" target="_blank" class="mr-2 text-indigo-600 hover:underline focus:outline-none">
                                    Generate Invoice
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p class="text-light">Actualmente no tienes ninguna factura asociada a tu cuenta</p>
        @endif

	@notsubscriber
		<p class="text-gray-600 text-light">Cuando te suscribes a un plan, aquí es donde podrás gestionar los feeds.</p>
		<a href="{{ route('wave.settings', 'plans') }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">Mirar Planes</a>
	@endsubscriber

</div>
