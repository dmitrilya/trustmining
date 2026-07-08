<x-profile.section h="Order history">
    <div class="space-y-2">
        @foreach ($user->orders as $order)
            <div class="pt-2 border-t border-slate-300 dark:border-slate-800">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-slate-800 dark:text-slate-200 font-extrabold text-base tracking-tight">
                        {{ $order->amount }} ₽
                    </div>

                    @switch($order->status)
                        @case('CONFIRMED')
                        @case('AUTHORIZED')
                            <div
                                class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-xxs text-emerald-500 font-black uppercase tracking-wider">
                                🟢 {{ __('Confirmed') }}
                            </div>
                        @break

                        @case('CANCELED')
                            <div
                                class="px-2.5 py-1 bg-rose-500/10 border border-rose-500/30 rounded-full text-xxs text-rose-500 font-black uppercase tracking-wider">
                                🔴 {{ __('Canceled') }}
                            </div>
                        @break

                        @default
                            <div
                                class="px-2.5 py-1 bg-amber-500/10 border border-amber-500/30 rounded-full text-xxs text-amber-500 font-black uppercase tracking-wider">
                                ⏳ {{ __('Awaiting payment') }}
                            </div>
                    @endswitch
                </div>

                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                    @switch($order->status)
                        @case('CONFIRMED')
                        @case('AUTHORIZED')
                            {{ __('Payment received successfully. Balance replenished') }}
                        @break

                        @case('CANCELED')
                            {{ __('Payment was canceled') }}
                        @break

                        @default
                            {{ __('Once funds are received, the balance will be replenished automatically') }}
                    @endswitch
                </p>

                <x-characteristics.characteristics>
                    <x-characteristics.characteristic name="Creation date" :value="$order->created_at" />
                    @if ($order->updated_at > $order->created_at)
                        <x-characteristics.characteristic name="Status update" :value="$order->updated_at" />
                    @endif
                </x-characteristics.characteristics>
            </div>
        @endforeach
    </div>
</x-profile.section>
