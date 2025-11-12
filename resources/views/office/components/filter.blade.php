<div class="relative mb-4 sm:mb-6" x-data="{ open: false, sugs: false }" @click.away="open = false">
    <div class="relative z-0 w-full group" @click="open = true">
        <input type="text" id="city" name="city" x-ref="search" placeholder=" "
            value="{{ request()->get('city') }}" autocomplete="off"
            @input.debounce.1000ms="sugs = dadataSuggs($el.value, $refs.suggestionList, open, 'city')"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-zinc-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
        <label for="city"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            {{ __('City') }}
        </label>
    </div>

    <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
        class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg dark:shadow-zinc-800 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
    </ul>
</div>

<x-peculiarities :ps="request()->peculiarities" model="office" :isForm="true"></x-peculiarities>
