@if ($message->message)
    <div class="flex {{ $auth->id == $message->user_id ? 'justify-end' : 'justify-start' }}">
        <div
            class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl {{ $auth->id == $message->user_id ? 'ml-6 rounded-tl-xl' : 'mr-6 rounded-tr-xl' }}">
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                <span class="date-transform text-xs font-normal text-gray-500 dark:text-gray-400"
                    data-date="{{ $message->created_at }}"></span>
            </div>

            <p class="text-sm font-normal text-gray-900 dark:text-white whitespace-pre-line">{{ $message->message }}
            </p>
        </div>
    </div>
@endif

<div x-data="{ open: false }">
    @if (count($message->images))
        <div class="flex {{ $auth->id == $message->user_id ? 'justify-end' : 'justify-start' }}">
            <div
                class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl {{ $auth->id == $message->user_id ? 'ml-6 rounded-tl-xl' : 'mr-6 rounded-tr-xl' }}">
                <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                    <span class="date-transform text-xs font-normal text-gray-500 dark:text-gray-400"
                        data-date="{{ $message->created_at }}"></span>
                </div>

                <div
                    class="grid gap-2 {{ $auth->id == $message->user_id ? 'justify-items-end' : 'justify-items-start' }} {{ count($message->images) > 1 ? (count($message->images) > 4 ? 'grid-cols-3' : 'grid-cols-2') : 'grid-cols-1' }}">
                    @foreach ($message->images as $image)
                        <div class="group relative max-h-60 max-w-max">
                            <div @click.self="$refs.image_preview.src = $el.nextElementSibling.src; open = true"
                                class="absolute w-full h-full max-h-max bg-gray-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                                <a data-tooltip-target="download-image-{{ $message->id }}-{{ $loop->index }}" download
                                    href="{{ Storage::url($image) }}"
                                    class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                    <svg class="w-4 h-4 text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3" />
                                    </svg>
                                </a>
                                <div id="download-image-{{ $message->id }}-{{ $loop->index }}" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Download image
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                            <img src="{{ Storage::url($image) }}" @load="scrollBottom($el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement)" class="rounded-lg max-h-full" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div style="display: none" x-show="open" tabindex="-1" aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden flex justify-center items-center fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40"></div>
        <div class="relative p-4 w-full max-w-2xl h-full max-w-max max-h-full z-50">
            <div class="relative place-items-center bg-white rounded-xl overflow-hidden shadow h-full dark:bg-gray-700" @click.away="open = false">
                <button @click="open = false" type="button"
                    class="absolute top-1 right-1 text-gray-500 bg-transparent hover:text-gray-600 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <img x-ref="image_preview" src="" alt="Image preview" class="max-h-full">
            </div>
        </div>
    </div>
</div>

@if (count($message->files))
    <div class="flex {{ $auth->id == $message->user_id ? 'justify-end' : 'justify-start' }}">
        <div
            class="flex flex-col w-full max-w-[400px] leading-1.5 px-3 py-2 border-gray-200 bg-white rounded-b-xl {{ $auth->id == $message->user_id ? 'ml-6 rounded-tl-xl' : 'mr-6 rounded-tr-xl' }}">
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                <span class="date-transform text-xs font-normal text-gray-500 dark:text-gray-400"
                    data-date="{{ $message->created_at }}"></span>
            </div>

            <div class="space-y-2">
                @foreach ($message->files as $file)
                    <x-document :path="$file['path']" :name="$file['name']"></x-document>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{-- <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
<svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
  <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
</svg>
</button>
<div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
<ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
  <li>
     <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
  </li>
</ul>
</div> --}}
