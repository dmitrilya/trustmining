<x-modal name="login" maxWidth="sm" rounded="rounded-xl">
    <div class="p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-gray-800 dark:text-gray-200">
                {{ __('Login') }}
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

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="relative z-0 w-full mb-5 group">
                <input type="email" value="{{ old('email') }}" name="email" id="login-email" placeholder=" "
                    required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="login-email"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Email') }}
                </label>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="password" value="{{ old('password') }}" name="password" id="login-password" placeholder=" "
                    required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="login-password"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Password') }}
                </label>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-zinc-950 border-gray-300 dark:border-zinc-800 text-indigo-600 shadow-sm shadow-logo-color focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-zinc-900"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" @click="show = false; $dispatch('open-modal', 'register');"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-zinc-900">
                    {{ __('Register') }}
                </button>

                <x-primary-button class="ml-3">
                    {{ __('Login') }}
                </x-primary-button>
            </div>

            <a class="mt-3 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-zinc-900"
                href="{{ route('password.request') }}" target="_blank">
                {{ __('Forgot your password?') }}
            </a>
        </form>
    </div>
</x-modal>
