<div class="{{ $relative ?? false ? 'relative ' : '' }}flex items-center h-full text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out"
    x-data="{ open: false }" @if (!isset($relative) || !$relative) @mouseover="open = true" @mouseleave="open = false" @endif>
    <button class="{{ $classes }}" @click="open = ! open">
        <div>{{ __('Menu') }}</div>

        <div class="ml-1">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-50" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-50"
        class="w-full absolute z-50 rounded-md shadow-lg origin-top left-0 top-0 mt-10 lg:mt-14" style="display: none"
        @click.away="open = false">
        <div
            class="rounded-b-2xl ring-b-1 ring-black ring-opacity-5 p-4 lg:p-10 lg:pt-8 xl:p-14 xl:pt-12 bg-white dark:bg-gray-700">
            <div class="sm:grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <div class="space-y-4 w-full mb-6 sm:mb-0">
                    <div class="text-sm text-gray-500 mb-6">{{ __('Project') }}</div>

                    {{-- <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z">
                            </path>
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('roadmap') }}">Roadmap</a>
                    </div> --}}

                    <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                        </svg>

                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('tariffs') }}">{{ __('Tariffs') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z">
                            </path>
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('articles') }}">{{ __('Blog') }}</a>
                    </div>

                    {{-- <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z">
                            </path>
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('career') }}">{{ __('Career in TrustMining') }}</a>
                    </div> --}}

                    <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z">
                            </path>
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('Privacy Policy') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2" aria-hidden="true" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                        </svg>

                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('document', ['path' => 'documents/agreement.pdf']) }}">{{ __('User Agreement') }}</a>
                    </div>
                </div>
                <div class="space-y-4 w-full">
                    <div class="text-sm text-gray-500 mb-6">{{ __('Knowledge Base') }}</div>

                    <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                            </path>
                        </svg>
                        <a class="text-sm lg:text-base text-gray-300 font-semibold"
                            href="#">{{ __('Events') }}</a>{{-- {{ route('events') }} --}}
                    </div>

                    <div class="group flex items-center">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('guides') }}">{{ __('Guides') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2" aria-hidden="true" stroke-width="1.5"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                d="M5.005 11.19V12l6.998 4.042L19 12v-.81M5 16.15v.81L11.997 21l6.998-4.042v-.81M12.003 3 5.005 7.042l6.998 4.042L19 7.042 12.003 3Z" />
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('database') }}">{{ __('Catalog of models') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('companies') }}">{{ __('Companies') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2" aria-hidden="true" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M6 15h12M6 6h12m-6 12h.01M7 21h10a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1Z" />
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('calculator') }}">{{ __('Mining calculator') }}</a>
                    </div>

                    <div class="group flex items-center">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 mr-2" aria-hidden="true" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
                        </svg>
                        <a class="under text-sm lg:text-base text-gray-800 font-semibold"
                            href="{{ route('metrics') }}">{{ __('Metrics') }}</a>
                    </div>
                </div>

                <div class="lg:col-span-2 xl:col-span-3 flex items-stretch gap-6">
                    @php
                        $article = App\Models\Article::latest()->first();
                        $guide = App\Models\Guide::inRandomOrder()->first();
                    @endphp

                    @if ($article)
                        <div class="hidden md:block w-full">
                            <div class="h-full bg-white shadow-md overflow-hidden rounded-lg flex-col justify-between">
                                @include('article.components.card', ['article' => $article])
                            </div>
                        </div>
                    @endif

                    <div class="hidden lg:block w-full">
                        @include('layouts.components.solutions-blurb')
                    </div>

                    <div class="hidden xl:block w-full">
                        @include('layouts.components.solutions-blurb')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
