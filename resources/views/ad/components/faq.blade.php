<section class="mt-4 sm:mt-6 lg:mt-8">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
            {{ __('Frequently Asked Questions') }}
        </h2>
    </div>

    <div itemprop="subjectOf" itemscope itemtype="https://schema.org/FAQPage" class="max-w-3xl mx-auto space-y-2 sm:space-y-4"
        x-data="{ active: null }">
        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 1 ? active = 1 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">Как осуществляется доставка {{ $ad->asicVersion->asicModel->name }}
                    {{ $ad->asicVersion->hashrate }}{{ $ad->asicVersion->measurement }} от компании
                    {{ $ad->user->name }}?</span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 1"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    @if ($ad->props['Availability'] == 'In stock')
                        <p class="mb-2">Оборудование находится в г. <b>{{ $ad->office->city }}</b>, отгрузка со склада
                            <b>{{ $ad->user->name }}</b> в течение 1-2 дней партнерской транспортной компанией.
                        </p>
                    @else
                        <p>Доставка из Китая до Москвы занимает до {{ $ad->props['Waiting (days)'] }} дней, далее — по
                            РФ
                            партнерской транспортной компанией. Уточните детали у менеджера через чат с компанией.</p>
                    @endif
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 2 ? active = 2 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">Какая гарантия на {{ $ad->asicVersion->asicModel->asicBrand->name }}
                    {{ $ad->asicVersion->asicModel->name }}?</span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 2"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    На новое оборудование действует официальная гарантия производителя. Вы можете <a target="_blank"
                        href="{{ route('warranty') }}" class="inline text-indigo-500 under font-medium">проверить
                        остаток
                        гарантии по S/N</a>. Уточните у <b>{{ $ad->user->name }}</b> возможность оформления расширенной
                    гарантии от их сервиса.
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 3 ? active = 3 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">Как рассчитать окупаемость {{ $ad->asicVersion->asicModel->name }} на
                    {{ $ad->asicVersion->hashrate }}{{ $ad->asicVersion->measurement }}?</span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 3"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                    Доход зависит от хешрейта, курса
                    {{ $ad->asicVersion->asicModel->algorithm->coins()->first('name')->name }} и сложности сети.
                    @if ($ad->version_data && count($ad->version_data->profits))
                        На данный момент {{ $ad->asicVersion->asicModel->name }}
                        на {{ $ad->asicVersion->hashrate }}{{ $ad->asicVersion->measurement }} приносит доход равный
                        <b>{{ $ad->version_data->profits[0]['profit'] }} USDT в день</b>.
                    @endif Расход — это стоимость вашей электроэнергии.
                    Рассчитайте прибыль в один клик в нашем <a target="_blank"
                        href="{{ route('calculator.modelver', ['asicModel' => $ad->asicVersion->asicModel->slug, 'asicVersion' => $ad->asicVersion->hashrate]) }}"
                        class="inline text-indigo-500 under font-medium ">калькуляторе доходности майнинга</a>.
                </div>
            </div>
        </div>

        <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
            class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
            <button @click="active !== 4 ? active = 4 : active = null"
                class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
                <span itemprop="name">Можно ли доверять компании {{ $ad->user->name }}?</span>
                <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                    :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 4"
                x-collapse x-cloak>
                <div itemprop="text"
                    class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 space-y-2">
                    <p>Для безопасности пользователей в нашем сервисе внедрена уникальная метрика Trust Factor.
                        Перейдите в карточку компании или посмотрите на значок в объявлении</p>
                    <div class="flex items-center gap-2"><span
                            class="size-3 md:size-4 rounded-full bg-green-500"></span>
                        <span>— Надежный партнер.</span>
                    </div>
                    <div class="flex items-center gap-2"><span
                            class="size-3 md:size-4 rounded-full bg-yellow-300"></span>
                        <span>— Есть замечания или мало опыта.</span>
                    </div>
                    <div class="flex items-center gap-2"><span class="size-3 md:size-4 rounded-full bg-red-600"></span>
                        <span>— Мало информации / Риски.</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($ad->user->hosting && $ad->user->tariff && $ad->user->tariff->can_have_hosting && !$ad->user->hosting->moderation)
            <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
                class="border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm bg-slate-100 dark:bg-slate-900 border-l-4 border-l-indigo-500 dark:border-l-indigo-500">
                <button @click="active !== 5 ? active = 5 : active = null"
                    class="flex justify-between items-center w-full p-4 text-left font-semibold text-sm sm:text-base text-slate-800 dark:text-slate-200 transition-all">
                    <span itemprop="name">Могу ли я разместить приобретенное оборудование в майнинг-хостинге компании
                        {{ $ad->user->name }}?</span>
                    <svg class="ml-2 sm:ml-3 w-5 h-5 transition-transform duration-300"
                        :class="active === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" x-show="active === 5"
                    x-collapse x-cloak>
                    <div itemprop="text"
                        class="p-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800">
                        Да, вы можете разместить <b>{{ $ad->asicVersion->asicModel->name }}</b> в дата-центре в
                        {{ $ad->user->hosting->address }}. Тарифы начинаются от
                        <br><b>{{ $ad->user->hosting->price }}р за кВт/ч</b>. Ознакомьтесь с <a
                            href="{{ route('company.hosting', ['user' => $ad->user->slug]) }}"
                            class="inline text-indigo-500 under font-medium" target="_blank">информацией о хостинге
                            компании
                            {{ $ad->user->name }}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
