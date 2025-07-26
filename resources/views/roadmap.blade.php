<x-app-layout>
    <div class="lg:grid lg:grid-cols-5" style="height: calc(100vh - 64.4px)">
        @guest
            <div class="col-span-2 bg-gray-900 hidden lg:flex flex-col h-full w-full relative z-10 overflow-hidden">
                <div class="h-full flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                    <div>
                        <a href="/">
                            <x-application-logo class="text-6xl" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden rounded-lg z-10">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" value="{{ old('name') }}" name="name" id="name"
                                    placeholder=" " required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                <label for="name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Name') . ' или ' . __('Company name') }}
                                </label>
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <input type="email" value="{{ old('email') }}" name="email" id="email"
                                    placeholder=" " required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                <label for="email"
                                    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Email') }}
                                </label>
                                <x-input-error :messages="$errors->get('email')" />
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <input type="password" value="{{ old('password') }}" name="password" id="password"
                                    placeholder=" " required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                <label for="password"
                                    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Password') }}
                                </label>
                                <x-input-error :messages="$errors->get('password')" />
                            </div>

                            <div class="relative z-0 w-full group">
                                <input type="password" value="{{ old('password') }}" name="password_confirmation"
                                    id="password_confirmation" placeholder=" " required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                <label for="password_confirmation"
                                    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Confirm Password') }}
                                </label>
                                <x-input-error :messages="$errors->get('password_confirmation')" />
                            </div>

                            <div class="flex items-center justify-end mt-6 lg:mt-8">
                                <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>

                                <x-primary-button class="ml-4">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="p-2 sm:p-4 lg:p-6">
                    <div class="text-xs text-gray-500">ИП </div>
                    <div class="text-xs text-gray-500 mb-2">ОГРНИП: </div>
                    <div class="text-xxs text-gray-400" style ="max-width: 1312px;">
                        © 2025{{ ($year = Carbon\Carbon::now()->year) != 2025 ? ' - ' . $year : '' }}. Не является
                        публичной офертой.
                    </div>
                </div>

                <svg viewBox="0 0 1208 1024"
                    class="absolute -translate-x-1/3 -translate-y-1/2 left-full top-1/2 h-[60rem] -z-10"
                    style="mask-image: radial-gradient(closest-side, white, transparent)">
                    <ellipse cx="604" cy="512" rx="604" ry="512"
                        fill="url(#6d1bd035-0dd1-437e-93fa-59d316231eb0)"></ellipse>
                    <defs>
                        <radialGradient id="6d1bd035-0dd1-437e-93fa-59d316231eb0">
                            <stop stop-color="#6366f1"></stop>
                            <stop offset="1" stop-color="#E935C1"></stop>
                        </radialGradient>
                    </defs>
                </svg>
            </div>
        @endguest

        <div class="md:col-span-3 @auth lg:col-start-2 @endauth bg-white relative overflow-y-auto">
            <svg class="absolute left-0 top-0 w-1.5 sm:w-2" aria-hidden="true" x-ref="timeline">
                <defs>
                    <pattern id=":S4:" width="6" height="8" patternUnits="userSpaceOnUse">
                        <path d="M0 0H6M0 8H6" class="stroke-gray-200" fill="none"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#:S4:)"></rect>
            </svg>

            <div class="w-full px-4 sm:px-8 xl:px-12 py-8 space-y-12 sm:space-y-16 lg:space-y-20 xl:space-y-28 overflow-x-hidden"
                x-init="$refs.timeline.style.height = $el.scrollHeight + 75 + 'px'">
                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('10-10-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Project launch') }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('Opening a demo version of a marketplace with a narrow specialization in mining for large companies') }}
                    </div>

                    <div class="my-6 w-full relative h-60 sm:h-80 py-8">
                        <img src="{{ Storage::url('public/roadmap/3.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute left-1/2 -translate-x-full rounded-xl shadow-xl -rotate-[15deg]">
                        <img src="{{ Storage::url('public/roadmap/1.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute left-1/2 -translate-x-1/2 rounded-xl shadow-xl z-10">
                        <img src="{{ Storage::url('public/roadmap/2.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute left-1/2  rounded-xl shadow-xl rotate-[15deg]">
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('Stage goals') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">{{ __('Invitation of large companies') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">{{ __('Testing basic functions') }}</li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">{{ __('Bug fixes and optimization') }}</li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Development of an advertising campaign') }}
                        </li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('20-10-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Update') . ' v 1.1' }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('Running Advertising Ads') }}
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('List of changes') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Booking advertising spaces') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">{{ __('Convenient auction system for advertising space') }}</li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('01-11-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Entering the market') }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('Launching an advertising campaign and actively attracting sellers and buyers to the site') }}
                    </div>

                    <div class="my-6 w-full relative h-60 sm:h-80 py-8">
                        <img src="{{ Storage::url('public/roadmap/6.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute -translate-x-1/2 left-[20%] rounded-xl shadow-xl -rotate-[6deg]">
                        <img src="{{ Storage::url('public/roadmap/5.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute -translate-x-1/2 left-[50%] rounded-xl shadow-xl">
                        <img src="{{ Storage::url('public/roadmap/4.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute -translate-x-1/2 left-[80%] rounded-xl shadow-xl rotate-[6deg]">
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('Stage goals') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Attract as many users as possible') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Monitor the load on the site and identify scaling opportunities') }}</li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Recruitment of moderators and support staff') }}</li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('05-11-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Update') . ' v 1.2' }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('SEO') }}
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('List of changes') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Mining calculator') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Improving indexing of site pages') }}
                        </li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('10-11-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Advertising with bloggers and collaborations') }}</div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('Stage goals') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Search for popular bloggers covering mining') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Collaborations to promote a platform with a convenient search for equipment from trusted suppliers and placement sites') }}
                        </li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('20-11-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Ability to write manuals') }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('Useful articles and guides') }}
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('Stage goals') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Create a platform section with accessible and reliable information about the world of mining') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Implement additional promotion of active companies on the platform') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Increasing indexed platform pages to improve search engine results') }}
                        </li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('05-12-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Update') . ' v 1.3' }}

                    </div>

                    <div class="my-6 w-full relative h-60 sm:h-80 py-8">
                        <img src="{{ Storage::url('public/roadmap/7.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute -translate-x-1/2 left-[30%] rounded-xl shadow-xl -rotate-[6deg]">
                        <img src="{{ Storage::url('public/roadmap/8.webp') }}" alt=""
                            class="h-44 sm:h-64 absolute -translate-x-1/2 left-[70%] rounded-xl shadow-xl rotate-[6deg]">
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('List of changes') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Integration with Yandex maps') }}
                            <a class="inline-block text-indigo-500 hover:text-indigo-400" target="_blank"
                                href="https://yandex.ru/maps-api/products">Yandex api</a>
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Finding the nearest sales offices') }}</li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Map and route planning in the company card') }}</li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('20-12-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Update') . ' v 1.4' }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('Analytics of ad quality and chosen promotion method') }}
                    </div>

                    <div class="md:text-lg text-gray-700 font-semibold mb-2 md:mb-4">{{ __('List of changes') }}</div>
                    <ul class="space-y-2 md:space-y-3 list-disc pl-8">
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Detailed statistics of buyer interest') }}
                        </li>
                        <li class="text-xs sm:text-sm text-gray-600 pl-2">
                            {{ __('Track lead activity and ad relevance') }}
                        </li>
                    </ul>
                </article>

                <article>
                    <header class="-ml-4 sm:-ml-8 xl:-ml-12 flex items-center mb-6 md:mb-8">
                        <div class="h-[0.0625rem] w-2.5 sm:w-4 bg-gray-500 mr-2 sm:mr-4 xl:mr-8 z-10 rounded-r-2xl">
                        </div>
                        <div class="date-transform text-xs text-gray-600 font-semibold" data-type="date"
                            data-date="{{ Carbon\Carbon::create('01-03-2025')->timestamp * 1000 }}"></div>
                    </header>

                    <div class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-800 font-semibold mb-2 lg:mb-3">
                        {{ __('Launching a mobile application') }}</div>
                    <div class="text-xs lg:text-sm text-gray-500 mb-6 md:mb-8">
                        {{ __('TrustMining in your pocket') }}
                    </div>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
