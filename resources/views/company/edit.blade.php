<x-app-layout title="Редактировать информацию о компании" description="Добавьте описание, фото и логотип к своей компании на сайте TrustMining">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ $company->name }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 shadow rounded-lg">
            <form method="post" action="{{ route('company.update', ['company' => $company->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @method('put')
                @csrf

                <div>
                    <x-input-label for="company" :value="__('Company TIN')" />
                    <x-text-input id="company" readonly disabled autocomplete="company"
                        value="{{ $company->card['inn'] }}" />
                </div>

                <div>
                    <x-input-label for="images" :value="__('Photo')" />
                    <x-file-input id="images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                        accept=".png,.jpg,.jpeg,.webp" multiple
                        @change="if ($el.files.length > 8) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 8]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-600" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 8 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="logo" :value="__('Logo for avatar')" />
                    <x-file-input id="logo" name="logo" class="mt-1 block w-full" :value="old('logo')"
                        accept=".png,.jpg,.jpeg,.webp" />
                    <p class="mt-1 text-sm text-gray-600" id="logo_help">PNG, JPG
                        or JPEG (max. 512KB, 1x1)</p>
                    <x-input-error :messages="$errors->get('logo')" />
                </div>

                <div>
                    <x-input-label for="bg_logo" :value="__('Logo for the card')" />
                    <x-file-input id="bg_logo" name="bg_logo" class="mt-1 block w-full" :value="old('bg_logo')"
                        accept=".png,.jpg,.jpeg,.webp" />
                    <p class="mt-1 text-sm text-gray-600" id="bg_logo_help">PNG, JPG
                        or JPEG (max. 1024KB)</p>
                    <x-input-error :messages="$errors->get('bg_logo')" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" rows="16" name="description"
                        class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-950 bg-gray-100 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm shadow-logo-color"
                        required maxlength="1500">{{ $company->description }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                @if ($company->user->tariff && $company->user->tariff->can_site_link)
                    <div>
                        <x-input-label for="site" :value="__('Link to site')" />
                        <x-text-input id="site" name="site" type="text" :value="$company->site"
                            autocomplete="site" />
                        <x-input-error :messages="$errors->get('site')" />
                    </div>
                @endif

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="$company->video"
                        autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
