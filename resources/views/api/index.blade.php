<x-app-layout :title="__('meta.api.title')" :description="__('meta.api.description')">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" name="API Documentation" />
        </x-breadcrumbs.breadcrumbs>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 text-slate-800 dark:text-slate-200 space-y-12">
            <div class="border-b border-slate-300 dark:border-slate-700 pb-6">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800 dark:text-slate-200">Trustmining API v1
                </h1>
                <p class="mt-2 text-base text-slate-600 dark:text-slate-400">
                    {{ __('Welcome to the TrustMining integration guide. Our API allows you to automate ad management in the mining hardware (ASIC miners) category.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        🔑 {{ __('Authorization and Restrictions') }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('To use the API, you need a personal access token, which you can generate in your personal account. Authentication is performed using') }}
                        <strong class="text-slate-800 dark:text-slate-200">Laravel Sanctum</strong>.
                    </p>
                    <div class="bg-amber-500/10 border-l-4 border-amber-500/30 p-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">⚠️</div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-800 dark:text-amber-200 font-bold">{{ __('Important Requirement') }}</p>
                                <p class="text-xs text-amber-500 mt-1">
                                    {{ __('Each API request must contain a header') }} <code
                                        class="bg-amber-100 dark:bg-amber-900/50 px-1 py-0.5 rounded">Accept: application/json</code>.
                                    {{ __('Without it, the server will return an incorrect response in HTML format instead of JSON') }}.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg p-4 text-xs space-y-3">
                    <div class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">{{ __('Required HTTP Headers') }}</div>
                    <div class="space-y-1">
                        <div class="text-emerald-500 font-bold">Authorization:</div>
                        <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 p-2 rounded-md text-slate-600 dark:text-slate-400">
                            Bearer 1|plainTextTokenValue...
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-emerald-500 font-bold">Accept:</div>
                        <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 p-2 rounded-md text-slate-600 dark:text-slate-400">
                            application/json
                        </div>
                    </div>
                    <div class="pt-2 border-t border-slate-300 dark:border-slate-700">
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ __('Rate Limit:') }}</span>
                        <p class="mt-1 text-slate-600 dark:text-slate-400 text-[11px]">{{ __('Maximum') }} <strong>60 {{ __('requests per minute') }}</strong>
                            {{ __('per account. If the limit is exceeded, will be returned a code') }} <code
                                class="text-rose-600 dark:text-rose-400 font-bold">429 Too Many Requests</code>.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-300 dark:border-slate-700 pt-8 space-y-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-amber-500/10 text-slate-200 text-xs font-bold px-2.5 py-1.5 rounded-md uppercase tracking-wide">GET</span>
                    <code class="text-sm font-bold text-slate-800 dark:text-slate-200">/api/v1/ads/get</code>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">— {{ __('Getting a list of ASIC miner ads') }}</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">{{ __('Return data structure') }}:</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-300 dark:border-slate-700 text-slate-500 uppercase tracking-wider">
                                        <th class="pr-2 py-2 font-semibold">{{ __('Field') }}</th>
                                        <th class="pr-2 py-2 font-semibold">{{ __('Type') }}</th>
                                        <th class="py-2 font-semibold">{{ __('Description / Validation') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-300 dark:divide-slate-700 text-slate-600 dark:text-slate-400">
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">id</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Internal unique ID of the ad in the system') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">name</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('ASIC miner model name') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">office</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('City of sales point') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">props</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">object</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('An object with specific product characteristics') }}</td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ condition</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Device status') }}: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">new</code>
                                            {{ __('or') }} <code class="text-slate-800 dark:text-slate-200 font-bold">used</code></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ availability</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Availability status') }}: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">in_stock</code> {{ __('or') }} <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">preorder</code></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ warranty</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int|null</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Warranty in months') }}. <span
                                                class="italic text-amber-500">({{ __('mandatory only if') }} condition == used)</span></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 pl-4 text-indigo-500 whitespace-nowrap">└ waiting</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int|null</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Delivery lead time in days') }}. <span
                                                class="italic text-amber-500">({{ __('mandatory only if') }} availability == preorder)</span></td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">price</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Unit cost') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">coin</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Settlement currency') }}: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">rub</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">usdt</code> {{ __('or') }}
                                            <code class="text-slate-800 dark:text-slate-200 font-bold">cny</code>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">with_vat</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Is VAT included in the stated price') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">hidden</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">
                                            {{ __('Visibility status: true (ad hidden), false (active on the site)') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            {{ __('Example of a successful JSON response') }} (200 OK):</h4>
                        <pre class="bg-slate-900 text-slate-200 text-xs p-4 rounded-lg overflow-x-auto border border-slate-800 shadow-inner">
{
  <span class="text-indigo-400">"ads"</span>: [
    {
      <span class="text-indigo-400">"id"</span>: 1045,
      <span class="text-indigo-400">"name"</span>: <span class="text-emerald-500">"Bitmain Antminer S19 Pro 110Th"</span>,
      <span class="text-indigo-400">"office"</span>: <span class="text-emerald-500">"{{ __('Moscow') }}"</span>,
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
                    <span class="bg-amber-500/10 text-slate-200 text-xs font-bold px-2.5 py-1.5 rounded-md uppercase tracking-wide">POST</span>
                    <code class="text-sm font-bold text-slate-800 dark:text-slate-200">/api/v1/ads/update</code>
                    <span class="text-slate-600 dark:text-slate-400 text-sm">— {{ __('Bulk editing of ad parameters') }}</span>
                </div>

                <div class="bg-rose-50 dark:bg-rose-950/20 border-l-4 border-rose-500/30 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">🚫</div>
                        <div class="ml-3">
                            <p class="text-sm text-rose-600 dark:text-rose-400 font-bold">{{ __('Editing restrictions') }}</p>
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1">
                                {{ __('Fields') }} <code class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">name</code>,
                                <code class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">office</code>,
                                <code class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">props.condition</code>
                                {{ __('and') }}
                                <code class="bg-rose-500/10 px-1 py-0.5 rounded-md font-bold">props.availability</code>
                                {{ __('are') }} <strong class="uppercase">{{ __('not editable') }}</strong>.
                                {{ __('Changing them is blocked in this method. If you need to list an item with a different name, condition, or availability status, you must create a completely new listing.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            {{ __('Editable request body parameters') }} (Payload):</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-300 dark:border-slate-700 text-slate-500 uppercase tracking-wider">
                                        <th class="pr-2 py-2 font-semibold">{{ __('Field') }}</th>
                                        <th class="pr-2 py-2 font-semibold">{{ __('Type') }}</th>
                                        <th class="py-2 font-semibold">{{ __('Validation Rules') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-300 dark:divide-slate-700 text-slate-600 dark:text-slate-400">
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.id</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Required') }} | {{ __('Your existing listing ID') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.price</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} | {{ __('Positive integer') }} (> 0)</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.coin</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">string</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} | {{ __('Acceptable Values') }}: <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">rub</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">usdt</code>, <code
                                                class="text-slate-800 dark:text-slate-200 font-bold">cny</code></td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.with_vat</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} | {{ __('Boolean value') }} (true/false)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.hidden</td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">boolean</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} | {{ __('Boolean value') }} (true/false)
                                        </td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.props.warranty
                                        </td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} |
                                            {{ __('Number of warranty months from 0 to 12') }} <span
                                                class="italic text-amber-500">({{ __('for used only') }})</span></td>
                                    </tr>
                                    <tr class="bg-slate-50/50 dark:bg-slate-800/10">
                                        <td class="pr-2 py-2 text-indigo-500 font-bold">ads.props.waiting
                                        </td>
                                        <td class="pr-2 py-2 text-slate-600 dark:text-slate-400">int</td>
                                        <td class="py-2 text-slate-600 dark:text-slate-400">{{ __('Optional') }} |
                                            {{ __('Waiting period in days from 1 to 120') }} <span
                                                class="italic text-amber-500">({{ __('for pre-order only') }})</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            {{ __('Example of a JSON array passed in a request') }}:</h4>
                        <pre class="bg-slate-900 text-slate-200 text-xs p-4 rounded-lg overflow-x-auto border border-slate-800 shadow-inner">
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
