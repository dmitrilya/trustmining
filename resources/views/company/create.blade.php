<x-app-layout title="Зарегистрировать компанию" description="Регистрация компании на сайте TrustMining">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Company') }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow rounded-lg">
            <form method="post" action="{{ route('company.store') }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf

                <div>
                    <x-input-label for="inn" :value="__('Company TIN')" />
                    <x-text-input id="inn" name="inn" required autocomplete="inn" />
                    <x-input-error :messages="$errors->get('inn')" />
                </div>

                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                    <div>
                        <p class="text-sm sm:text-base text-gray-600 font-bold mb-3">
                            {{ __('For LLC') }}
                        </p>
                        <ul class="space-y-2 list-disc ms-5">
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Extract from the Unified State Register of Legal Entities') }}
                            </li>
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Decision/minutes on the establishment of LLC') }}
                            </li>
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Constituent agreement (if any)') }}
                            </li>
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Charter of LLC') }}
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm sm:text-base text-gray-600 font-bold mb-3">
                            {{ __('For individual entrepreneurs') }}
                        </p>
                        <ul class="space-y-2 list-disc ms-5">
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('USRIP record sheet') }}
                            </li>
                            <li class="text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                {{ __('Notification of registration with the Federal Tax Service') }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div>
                    <x-input-label for="documents" :value="__('Documents')" />
                    <x-file-input id="documents" name="documents[]" class="mt-1 block w-full" multiple
                        autocomplete="documents" accept=".doc,.docx" required
                        @change="if ($el.files.length > 4) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 4]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-600" id="documents_help">DOC (max. 1MB, max. 4
                        items)
                    </p>
                    <x-input-error :messages="$errors->get('documents')" />
                    @foreach ($errors->get('documents.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
