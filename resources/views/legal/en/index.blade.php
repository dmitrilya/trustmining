<x-app-layout :title="__('meta.legal.title')" :description="__('meta.legal.description')">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" name="{{ __('Legal services') }}" />
        </x-breadcrumbs.breadcrumbs>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-4 md:p-6 space-y-16">
            <div class="max-w-3xl space-y-6 sm:space-y-8 lg:space-y-10">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/10 border border-indigo-500/30 rounded-full text-xs text-indigo-400 font-bold uppercase tracking-wider">
                    🛡️ Legal protection for crypto businesses
                </span>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight text-slate-800 dark:text-slate-200 leading-tight">
                    Legal support for miners and investors
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm md:text-base max-w-2xl">
                    We provide comprehensive legal security in the cryptocurrency and digital financial assets (DFA) market. We minimize the risks of
                    blockages, protect assets in court and support large turnkey equipment supply deals.
                </p>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="#consultation"
                        class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition shadow-lg shadow-indigo-600/20 active:scale-95">
                        Get a consultation
                    </a>
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Lawyers available 24/7
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-slate-200 tracking-tight">Our range of services
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Specialized practice in blockchain technology and energy</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-indigo-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                📋</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition">
                                Registration and licensing</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Assistance with the registration and licensing of activities related to DFAs and cryptocurrency. Setting up legal
                                exchanges, crypto funds and IT companies in accordance with the current legislation.
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-emerald-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                💸</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-400 transition">
                                Recovery from crypto scammers</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Locating and recovering funds lost as a result of fraudulent platforms, phishing exchanges and scam projects.
                                Initiating criminal cases and chargeback procedures.
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-indigo-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                ⚡</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition">
                                Energy supply for mining</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Legal support in the field of energy supply. Signing direct contracts with energy sales companies, increasing
                                capacity, defending against accusations of "unmetered consumption" and tariff disputes.
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-emerald-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                📦</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-400 transition">
                                Equipment supply support</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Support for transactions involving the purchase and supply of mining equipment (ASIC miners, containers). Control
                                over customs clearance, leasing agreements and international invoices.
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-indigo-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                🏗️</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition">
                                Legal support for mining</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Subscription-based legal services for mining hotels and data centers. Drafting equipment hosting agreements,
                                security regulations and employment contracts with staff.
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/40 border border-slate-300 dark:border-slate-700 p-5 rounded-xl flex flex-col justify-between hover:border-rose-500/50 transition group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 bg-rose-500/10 border border-rose-500/30 rounded-xl flex items-center justify-center text-xl shadow">
                                🚨</div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 group-hover:text-rose-400 transition">
                                Disputes under Federal Law No. 115-FZ and No. 161-FZ</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Protection of rights when bank accounts, cards and P2P transactions are blocked. Preparing a compliance
                                document package, unblocking fiat gateways and appealing bank refusals.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-950/20 border-l-4 border-amber-500 p-4 rounded-r-md">
                <div class="flex items-start gap-3">
                    <div class="text-lg">⚠️</div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-amber-800 dark:text-amber-200">Risks of operating in the gray zone</h4>
                        <p class="text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
                            With the tightening of control by the Central Bank of the Russian Federation and Rosfinmonitoring, any P2P activity or
                            industrial mining without a legal structure inevitably leads to requests under Federal Law No. 115-FZ and a complete
                            freeze of capital. Building a compliant legal structure in a timely manner costs 10 times less than the subsequent
                            litigation expenses.
                        </p>
                    </div>
                </div>
            </div>

            <div id="consultation" class="border-t border-slate-300 dark:border-slate-700 pt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-slate-200 tracking-tight">Need a lawyer&rsquo;s
                        help?</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Describe your situation in the form. Our specialized lawyers will review the case materials and contact
                        you within 15 minutes for an initial analysis of the prospects of the dispute.
                    </p>
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/20 border border-slate-300 dark:border-slate-700 rounded-xl space-y-2 text-xs text-slate-500">
                        <div>Your data is protected by an NDA</div>
                        <div>Confidential and anonymous</div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-slate-50 dark:bg-slate-800/30 border border-slate-300 dark:border-slate-700 p-4 md:p-6 rounded-xl">
                    <form method="POST" action="" x-data="{ name: '', contact: '', message: '', isSending: false }"
                        @submit.prevent="isSending = true; axios.post(\$el.action, { name, contact, message }).then(r => {
                              isSending = false;
                              if (r.data.success) {
                                  pushToastAlert(r.data.message, 'success');
                                  name = ''; contact = ''; message = '';
                              } else {
                                  pushToastAlert(r.data.message, 'error');
                              }
                          }).catch(e => { isSending = false; pushToastAlert('Sending error', 'error'); })"
                        class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Your name or company</label>
                                <input type="text" x-model="name" required placeholder="Ivan I."
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-sm px-4 py-2.5 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telegram or Phone</label>
                                <input type="text" x-model="contact" required placeholder="@username / +7..."
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-sm px-4 py-2.5 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Brief description of the situation</label>
                            <textarea x-model="message" required rows="3"
                                placeholder="Describe the essence of the problem (e.g.: the bank blocked my account under 115-FZ after a P2P transaction)..."
                                class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-sm px-4 py-2.5 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none resize-none"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" :disabled="isSending"
                                class="w-full sm:w-auto px-6 py-3 bg-primary-gradient rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 transition disabled:opacity-50">
                                <span x-show="!isSending">Send request</span>
                                <span x-show="isSending" class="animate-pulse">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
