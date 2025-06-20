<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Top up your balance') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('order.store') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="amount" :value="__('Amount')" />
                    <x-text-input id="amount" name="amount" type="number" min="100" autocomplete="off"
                        required />
                    <x-input-error :messages="$errors->get('amount')" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
                    <div>
                        <input class="sr-only peer" type="radio" name="method" id="card" value="card"
                            required>

                        <label for="card"
                            class="w-full cursor-pointer px-4 py-6 md:py-8 rounded-lg border border-gray-200 text-gray-500 hover:text-gray-900 shadow-md hover:shadow-lg peer peer-checked:shadow-xl peer-checked:text-gray-900 bg-white flex items-center justify-center">
                            <svg class="w-8 h-8" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4Zm0 6h16v6H4v-6Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5 14a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm5 0a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1Z" />
                            </svg>

                            <div class="ml-4 text-lg md:text-xl font-semibold">
                                {{ __('Card') }}</div>
                        </label>
                    </div>

                    <div>
                        <input class="sr-only peer" type="radio" name="method" id="qr" value="qr"
                            required>

                        <label for="qr"
                            class="w-full cursor-pointer px-4 py-6 md:py-8 rounded-lg border border-gray-200 text-gray-500 hover:text-gray-900 shadow-md hover:shadow-lg peer peer-checked:shadow-xl peer-checked:text-gray-900 bg-white flex items-center justify-center">
                            <svg class="w-8 h-8" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                            </svg>

                            <div class="ml-4 text-lg md:text-xl font-semibold">
                                {{ __('QR-code') }}</div>
                        </label>
                    </div>

                    <div>
                        <input class="sr-only peer" type="radio" name="method" id="invoice" value="invoice"
                            required>

                        <label for="invoice"
                            class="w-full cursor-pointer px-4 py-6 md:py-8 rounded-lg border border-gray-200 text-gray-500 hover:text-gray-900 shadow-md hover:shadow-lg peer peer-checked:shadow-xl peer-checked:text-gray-900 bg-white flex items-center justify-center">
                            <svg class="w-8 h-8" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                            </svg>

                            <div class="ml-4 text-lg md:text-xl font-semibold">
                                {{ __('QR-code') }}</div>
                        </label>
                    </div>
                </div>

                <x-primary-button class="block w-full sm:w-max ml-auto md:!mt-10">{{ __('Top up') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
