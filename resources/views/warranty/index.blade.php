<x-app-layout title="Проверить гарантию ASIC майнера"
    description="Узнать остаток гарантии Whatsminer, Bitmain, Canaan, Iceriver">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Check warranty') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6 mb-6">
            <section>
                <h3
                    class="text-sm xs:text-base sm:text-lg text-gray-700 dark:text-gray-200 font-bold mb-3 xs:mb-4 sm:mb-5">
                    Whatsminer</h3>
                <div class="flex flex-col sm:flex-row sm:items-end">
                    <div class="w-full">
                        <x-text-input class="w-full !mt-0" id="sn_wm" type="text" :placeholder="__('Serial number')" />
                    </div>
                    <div class="flex flex-col xs:flex-row mt-2 sm:mt-0 sm:ml-3">
                        <div class="min-w-40">
                            <x-text-input class="w-full !mt-0" id="sn_wm_r" x-ref="sn_wm_r" type="text" :placeholder="__('Warranty')" readonly />
                        </div>
                        <x-primary-button class="block mt-2 xs:mt-0 xs:ml-2 sm:ml-3 text-xs"
                            @click="axios.get('https://www.whatsminer.com/renren-fast/app/RepairWorkOrder/warranty?str=1&lang=en_US').then(r => {
                                    if (r.data.code == 1021) $refs.sn_wm_r.value = r.data.msg;
                            })">
                            {{ __('Check') }}
                        </x-primary-button>
                    </div>
                </div>
                <a class="text-xxs sm:text-xs text-indigo-400 hover:text-indigo-600 underline    mt-2 sm:mt-3"
                    target="_blank"
                    href="https://www.whatsminer.com/src/views/support.html">{{ __('Check on the official website') }}</a>
            </section>
        </div>
    </div>



    {{-- https://shop-repair.bitmain.com/api/warranty/getWarranty?serialNumber=1
    https://m.bitmain.com/support/warranty

    https://www.canaan.io/?do_action=action.supports_sn_warranty POST
    -sn
    https://www.canaan.io/support/warranty_check

    https://www.iceriver.io/wp-admin/admin-post.php POST
    -sn_number
    -action=warrantycheck_ajax_action
    https://www.iceriver.io/warranty-inquiry/

    https://user-api.jasminer.com/jasminer/logistics/product/info/getByMachineCode POST
    -machineCode
    https://www.jasminer.com/#/support/searchsn --}}
</x-app-layout>
