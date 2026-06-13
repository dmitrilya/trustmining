<x-app-layout title="Документация API Trustmining"
    description="Руководство по использованию API Trustmining. Создайте собственную интеграцию">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" name="API Documentation" />
        </x-breadcrumbs>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 text-slate-800 dark:text-slate-200 space-y-12">
            <div class="border-b border-slate-300 dark:border-slate-700 pb-6">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800 dark:text-slate-200">Trustmining API v1
                </h1>
                <p class="mt-2 text-base text-slate-600 dark:text-slate-400">
                    Добро пожаловать в руководство по интеграции с платформой Trustmining. Наше API позволяет
                    автоматизировать управление объявлениями в категории майнинг-оборудования (ASIC-майнеры).
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        🔑 Авторизация и Ограничения
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        Для работы с API вам необходим персональный токен доступа, который можно сгенерировать в личном
                        кабинете. Аутентификация выполняется на базе технологии <strong
                            class="text-slate-800 dark:text-slate-200">Laravel Sanctum</strong>.
                    </p>
                    <div class="bg-amber-500/10 border-l-4 border-amber-500/30 p-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">⚠️</div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-800 dark:text-amber-200 font-bold">Важное требование</p>
                                <p class="text-xs text-amber-500 mt-1">
                                    Каждый запрос к API обязан содержать заголовок <code
                                        class="bg-amber-100 dark:bg-amber-900/50 px-1 py-0.5 rounded">Accept:
                                        application/json</code>. Без него сервер вернет некорректный ответ в формате
                                    HTML вместо JSON.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg p-4 text-xs space-y-3">
                    <div class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Обязательные
                        HTTP-заголовки</div>
                    <div class="space-y-1">
                        <div class="text-emerald-500 font-bold">Authorization:</div>
                        <div
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-2 rounded-md text-slate-600 dark:text-slate-400">
                            Bearer 1|plainTextTokenValue...
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-emerald-500 font-bold">Accept:</div>
                        <div
                            class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-2 rounded-md text-slate-600 dark:text-slate-400">
                            application/json
                        </div>
                    </div>
                    <div class="pt-2 border-t border-slate-300 dark:border-slate-700">
                        <span class="font-bold text-slate-800 dark:text-slate-200">Ограничение частоты (Rate
                            Limit):</span>
                        <p class="mt-1 text-slate-600 dark:text-slate-400 text-[11px]">Максимум <strong>60 запросов в
                                минуту</strong> на один
                            аккаунт. При превышении возвращается код <code
                                class="text-rose-500 font-bold">429 Too Many
                                Requests</code>.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-300 dark:border-slate-700 pt-8 space-y-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span
                        class="bg-amber-500/10 text-slate-200 text-xs font-bold px-2.5 py-1.5 rounded-md uppercase tracking-wide">GET</span>
                    <code class="text-sm font-bold text-slate-800 dark:text-slate-200">/api/v1/ads/get</code>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">— Получение списка объявлений
                        ASIC-майнеров</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Структура возвращаемых
                            данных:</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr
                                        class="border-b border-slate-300 dark:border-slate-700 text-slate-500 uppercase tracking-wider">
                                        <th class="pr-2 py-2 font-semibold">Поле</th>
                                        <th class="pr-2 py-2 font-semibold">Тип</th>
                                        <th class="py-2 font-semibold">Описание / Валидация</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-slate-300 dark:divide-slate-700 text-slate-600 dark:text-slate-400">
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">id</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Внутренний уникальный ID
                                            объявления в системе</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">name</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Название модели ASIC-майнера
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">office</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Город точки продаж
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">props</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">object</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Объект со специфическими
                                            характеристиками товара</td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ condition</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Состояние устройства: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">new</code> (новое)
                                            или <code class="text-slate-800 dark:text-slate-200 font-bold">used</code>
                                            (Б/У)</td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ availability</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Статус наличия: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">in_stock</code> (в
                                            наличии) или <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">preorder</code>
                                            (предзаказ)</td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ warranty</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int|null</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Гарантия в месяцах. <span
                                                class="italic text-amber-500">(обязательно, только
                                                если condition ==
                                                used)</span></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ waiting</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int|null</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Срок ожидания поставки в
                                            днях. <span class="italic text-amber-500">(обязательно,
                                                только если availability ==
                                                preorder)</span></td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">price</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Стоимость единицы
                                            оборудования</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">coin</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Валюта расчетов: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">rub</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">usdt</code> или
                                            <code class="text-slate-800 dark:text-slate-200 font-bold">cny</code>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">with_vat</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Включен ли НДС в указанную
                                            стоимость</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">hidden</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Статус видимости: true
                                            (объявление скрыто), false (активно на
                                            сайте)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Пример успешного
                            JSON-ответа (200 OK):</h4>
                        <pre class="bg-slate-900 text-slate-300 text-xs p-4 rounded-lg overflow-x-auto border border-slate-800 shadow-inner">
{
  <span class="text-indigo-400">"ads"</span>: [
    {
      <span class="text-indigo-400">"id"</span>: 1045,
      <span class="text-indigo-400">"name"</span>: <span class="text-emerald-500">"Bitmain Antminer S19 Pro 110Th"</span>,
      <span class="text-indigo-400">"office"</span>: <span class="text-emerald-500">"Москва"</span>,
      <span class="text-indigo-400">"props"</span>: {
        <span class="text-indigo-400">"condition"</span>: <span class="text-emerald-500">"used"</span>,
        <span class="text-indigo-400">"availability"</span>: <span class="text-emerald-500">"in_stock"</span>,
        <span class="text-indigo-400">"warranty"</span>: 3,
        <span class="text-indigo-400">"waiting"</span>: <span class="text-indigo-500">null</span>
      },
      <span class="text-indigo-400">"price"</span>: 145000,
      <span class="text-indigo-400">"coin"</span>: <span class="text-emerald-500">"rub"</span>,
      <span class="text-indigo-400">"with_vat"</span>: <span class="text-indigo-500">false</span>,
      <span class="text-indigo-400">"hidden"</span>: <span class="text-indigo-500">false</span>
    },
    {
      <span class="text-indigo-400">"id"</span>: 1046,
      <span class="text-indigo-400">"name"</span>: <span class="text-emerald-500">"MicroBT Whatsminer M50 120Th"</span>,
      <span class="text-indigo-400">"props"</span>: {
        <span class="text-indigo-400">"condition"</span>: <span class="text-emerald-500">"new"</span>,
        <span class="text-indigo-400">"availability"</span>: <span class="text-emerald-500">"preorder"</span>,
        <span class="text-indigo-400">"warranty"</span>: <span class="text-indigo-500">null</span>,
        <span class="text-indigo-400">"waiting"</span>: 14
      },
      <span class="text-indigo-400">"price"</span>: 1850,
      <span class="text-indigo-400">"coin"</span>: <span class="text-emerald-500">"usdt"</span>,
      <span class="text-indigo-400">"with_vat"</span>: <span class="text-indigo-500">true</span>,
      <span class="text-indigo-400">"hidden"</span>: <span class="text-indigo-500">false</span>
    }
  ]
}</pre>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-300 dark:border-slate-700 pt-8 space-y-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span
                        class="bg-amber-500/10 text-slate-200 text-xs font-bold px-2.5 py-1.5 rounded-md uppercase tracking-wide">POST</span>
                    <code class="text-sm font-bold text-slate-800 dark:text-slate-200">/api/v1/ads/update</code>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">— Массовое редактирование параметров
                        объявлений</span>
                </div>

                <div class="bg-rose-50 dark:bg-rose-950/20 border-l-4 border-rose-500/30 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">🚫</div>
                        <div class="ml-3">
                            <p class="text-sm text-rose-800 dark:text-rose-200 font-bold">Ограничение на редактирование
                            </p>
                            <p class="text-xs text-rose-500 mt-1">
                                Поля <code
                                    class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">name</code>,
                                <code
                                    class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">office</code>,
                                <code
                                    class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">props.condition</code>
                                и
                                <code
                                    class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">props.availability</code>
                                являются <strong class="uppercase">нередактируемыми</strong>. Их изменение в этом
                                методе заблокировано. Если вам нужно выставить товар с другим названием, состоянием или
                                статусом наличия, вам необходимо создать абсолютно новое объявление.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Редактируемые
                            параметры тела запроса (Payload):</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr
                                        class="border-b border-slate-300 dark:border-slate-700 text-slate-500 uppercase tracking-wider">
                                        <th class="pr-2 py-2 font-semibold">Поле</th>
                                        <th class="pr-2 py-2 font-semibold">Тип</th>
                                        <th class="py-2 font-semibold">Правила валидации</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-slate-300 dark:divide-slate-700 text-slate-600 dark:text-slate-400">
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.id</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Обязательное | Существующий
                                            ID вашего
                                            объявления</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.price</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Целое
                                            положительное число (> 0)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.coin</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Допустимые
                                            значения: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">rub</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">usdt</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">cny</code></td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.with_vat</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Логическое
                                            значение (true/false)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.hidden</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Логическое
                                            значение (true/false)
                                        </td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.props.warranty
                                        </td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Количество
                                            месяцев гарантии от 0 до 12 <span class="italic text-amber-500">(только для
                                                Б/У)</span></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.props.waiting
                                        </td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">Опционально | Срок ожидания
                                            в днях от 1 до 120 <span class="italic text-amber-500">(только для
                                                предзаказа)</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Пример передаваемого
                            JSON-массива в запросе:</h4>
                        <pre class="bg-slate-900 text-slate-300 text-xs p-4 rounded-lg overflow-x-auto border border-slate-800 shadow-inner">
{
  <span class="text-indigo-400">"ads"</span>: [
    {
      <span class="text-indigo-400">"id"</span>: 1045,
      <span class="text-indigo-400">"price"</span>: 149000,
      <span class="text-indigo-400">"hidden"</span>: <span class="text-indigo-500">false</span>,
      <span class="text-indigo-400">"props"</span>: {
        <span class="text-indigo-400">"warranty"</span>: 6
      }
    },
    {
      <span class="text-indigo-400">"id"</span>: 1046,
      <span class="text-indigo-400">"price"</span>: 1810,
      <span class="text-indigo-400">"with_vat"</span>: <span class="text-indigo-500">false</span>
    }
  ]
}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
