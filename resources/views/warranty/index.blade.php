<x-app-layout title="Проверить гарантию ASIC майнера: остаток гарантийного обслуживания"
    description="Узнать остаток гарантии Whatsminer, Bitmain, Canaan, Iceriver, Jasminer">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Check warranty') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        <section>
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-4 sm:mb-6"
                x-data="{ sn: null }">
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-800 dark:text-gray-100 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Whatsminer</h3>
                <div class="flex flex-col lg:flex-row lg:items-end">
                    <div class="w-full">
                        <x-text-input class="w-full !mt-0 text-xs sm:text-sm" id="sn_wm" type="text"
                            ::value="sn" @input="sn = $el.value" :placeholder="__('Serial number')" />
                    </div>
                    <div class="flex flex-col xs:flex-row mt-2 lg:mt-0 lg:ml-3">
                        <div class="w-full lg:min-w-80">
                            <x-text-input class="w-full !mt-0 text-xs sm:text-sm" id="sn_wm_r" x-ref="sn_wm_r"
                                type="text" :placeholder="__('Warranty')" disabled readonly />
                        </div>
                        <x-primary-button class="block mt-2 xs:mt-0 xs:ml-2 sm:ml-3 text-xxs sm:text-xs"
                            @click="$el.classList.add('loading');$el.disabled = true;axios.get('https://www.whatsminer.com/renren-fast/app/RepairWorkOrder/warranty?str=' + sn + '&lang=en_US').then(r => {
                                    if (r.data.code == 1021) $refs.sn_wm_r.value = r.data.msg;
                                    else $refs.sn_wm_r.value = '{{ __('Warranty until') }} ' + new Date(r.data.dateList[1]).toLocaleDateString(window.locale, {
                                        year: 'numeric', month: 'long', day: 'numeric'
                                    });
                                    $el.classList.remove('loading');
                                    $el.disabled = false;
                            })">
                            {{ __('Check') }}
                        </x-primary-button>
                    </div>
                </div>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline mt-2 sm:mt-3"
                    target="_blank"
                    href="https://www.whatsminer.com/src/views/support.html">{{ __('Check on the official website') }}</a>
            </div>
        </section>

        <section>
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6"
                x-data="{ sn: null }">
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-800 dark:text-gray-100 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Bitmain</h3>
                <div class="flex flex-col lg:flex-row lg:items-end">
                    <div class="w-full">
                        <x-text-input class="w-full !mt-0 text-xs sm:text-sm" id="sn_bm" type="text"
                            ::value="sn" @input="sn = $el.value" :placeholder="__('Serial number')" />
                    </div>
                    <div class="flex flex-col xs:flex-row mt-2 lg:mt-0 lg:ml-3">
                        <div class="w-full lg:min-w-80">
                            <x-text-input class="w-full !mt-0 text-xs sm:text-sm" id="sn_bm_r" x-ref="sn_bm_r"
                                type="text" :placeholder="__('Warranty until')" disabled readonly />
                        </div>
                        <x-primary-button class="block mt-2 xs:mt-0 xs:ml-2 sm:ml-3 text-xxs sm:text-xs"
                            @click="$el.classList.add('loading');$el.disabled = true;axios.get('https://shop-repair.bitmain.com/api/warranty/getWarranty?serialNumber=' + sn).then(r => {
                                    if (r.data.warranty == 0) $refs.sn_bm_r.value = '{{ __('Warranty has expired or the number does not exist') }}';
                                    else $refs.sn_bm_r.value = '{{ __('Warranty until') }} ' + Date.now().setDate(Date.now().getDate() + r.data.warranty).toLocaleDateString(window.locale, {
                                        year: 'numeric', month: 'long', day: 'numeric'
                                    });
                                    $el.classList.remove('loading');
                                    $el.disabled = false;
                            })">
                            {{ __('Check') }}
                        </x-primary-button>
                    </div>
                </div>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline    mt-2 sm:mt-3"
                    target="_blank"
                    href="https://m.bitmain.com/support/warranty">{{ __('Check on the official website') }}</a>
            </div>
        </section>

        <section>
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6"
                x-data="{ sn: null }">
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-800 dark:text-gray-100 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Canaan</h3>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline    mt-2 sm:mt-3"
                    target="_blank"
                    href="https://www.canaan.io/support/warranty_check">{{ __('Check on the official website') }}</a>
            </div>
        </section>

        <section>
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6"
                x-data="{ sn: null }">
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-800 dark:text-gray-100 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Iceriver</h3>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline    mt-2 sm:mt-3"
                    target="_blank"
                    href="https://www.iceriver.io/warranty-inquiry">{{ __('Check on the official website') }}</a>
            </div>
        </section>

        <section>
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6"
                x-data="{ sn: null }">
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-800 dark:text-gray-100 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Jasminer</h3>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline    mt-2 sm:mt-3"
                    target="_blank"
                    href="https://www.jasminer.com/#/support/searchsn">{{ __('Check on the official website') }}</a>
            </div>
        </section>
    </div>

    {{-- 
    https://www.canaan.io/?do_action=action.supports_sn_warranty POST
    -sn

    https://www.iceriver.io/wp-admin/admin-post.php POST
    -sn_number
    -action=warrantycheck_ajax_action

    https://user-api.jasminer.com/jasminer/logistics/product/info/getByMachineCode POST
    -machineCode
     --}}
</x-app-layout>
