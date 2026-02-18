<x-modal name="register" maxWidth="sm" rounded="rounded-xl">
    <div class="p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-gray-800 dark:text-gray-200">
                {{ __('Register') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-zinc-950 text-gray-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="relative z-0 w-full mb-5 group">
                <input type="text" value="{{ old('name') }}" name="name" id="register-name" placeholder=" "
                    required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="register-name"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Name') . ' или ' . __('Company name') }}
                </label>
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="email" value="{{ old('email') }}" name="email" id="register-email" placeholder=" "
                    required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="register-email"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Email') }}
                </label>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="password" value="{{ old('password') }}" name="password" id="register-password"
                    placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="register-password"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Password') }}
                </label>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="relative z-0 w-full group">
                <input type="password" value="{{ old('password') }}" name="password_confirmation"
                    id="register-password_confirmation" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="register-password_confirmation"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Confirm Password') }}
                </label>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="flex items-center justify-end mt-6 lg:mt-8">
                <button type="button" @click="show = false; $dispatch('open-modal', 'login');"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-zinc-900">
                    {{ __('Login') }}
                </button>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
