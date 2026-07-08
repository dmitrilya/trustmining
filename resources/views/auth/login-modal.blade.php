<x-modal name="login" maxWidth="sm" rounded="rounded-xl">
    <div class="p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Login') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('login', ['redirect' => url()->current()]) }}">
            @csrf

            <div class="relative z-0 w-full mb-5 group">
                <input type="email" value="{{ old('email') }}" name="email" id="login-email" placeholder=" "
                    required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-slate-800 dark:text-slate-200 border-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="login-email"
                    class="absolute text-sm text-slate-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Email') }}
                </label>
                @if (isset($errors))
                    <x-inputs.input-error :messages="$errors->get('email')" />
                @endif
            </div>

            <div x-data="{ show: false }" class="relative z-0 w-full mb-5 group">
                <input :type="show ? 'text' : 'password'" value="{{ old('password') }}" name="password"
                    id="login-password" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-slate-800 dark:text-slate-200 border-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                <label for="login-password"
                    class="absolute text-sm text-slate-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Password') }}
                </label>
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" @click="show = !show">
                    <template x-if="!show">
                        <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.79 0 8.601 3.049 9.964 6.678.045.122.045.255 0 .377-1.363 3.629-5.174 6.678-9.964 6.678-4.79 0-8.601-3.049-9.964-6.678z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </template>
                    <template x-if="show">
                        <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </template>
                </button>
                @if (isset($errors))
                    <x-inputs.input-error :messages="$errors->get('password')" />
                @endif
            </div>

            <x-inputs.checkbox class="block mt-4" textClasses="text-slate-600 dark:text-slate-400" name="remember"
                value="with_vat">
                {{ __('Remember me') }}
            </x-inputs.checkbox>

            <div class="flex items-center justify-end mt-4">
                <button type="button" @click="show = false; $dispatch('open-modal', 'register');"
                    class="text-sm text-slate-800 dark:text-slate-200 under">
                    {{ __('Register') }}
                </button>

                <x-buttons.primary-button class="ml-3">
                    {{ __('Login') }}
                </x-buttons.primary-button>
            </div>

            <a class="mt-3 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
                href="{{ route('password.request') }}" target="_blank">
                {{ __('Forgot your password?') }}
            </a>
        </form>

        @include('auth.socials')
    </div>
</x-modal>
