@php
    $p = !$user->tracks->count()
        ? 'To receive alerts about price changes for equipment or a specific listing, click the "Track" button on the relevant page'
        : null;
@endphp

<x-profile.section h="Tracked prices" :p="$p">
    <div id="tracked-prices-list">
        @foreach ($user->tracks as $track)
            <div class="py-2 border-t border-slate-300 dark:border-slate-700">
                <div class="flex justify-between items-center mb-3">
                    <div class="text-slate-800 dark:text-slate-200 font-bold">
                        {{ $track->trackable_type == 'ad' ? $track->trackable->asicVersion->asicModel->name : $track->trackable->name }}
                    </div>

                    <x-buttons.secondary-button class="handle-track" data-trackable-type="{{ $track->trackable_type }}"
                        data-trackable-id="{{ $track->trackable_id }}">
                        {{ __('Untrack price') }}
                    </x-buttons.secondary-button>
                </div>

                <div class="text-xs text-slate-600 dark:text-slate-400">
                    @if ($track->trackable_type == 'ad')
                        {{ __('Advertisement by seller') }} <b>{{ $track->trackable->user->name }}</b>
                    @else
                        {{ __('All ads for sale of this model') }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('tracked-prices-list');
            if (!container) return;

            const needsTgAuth = {{ $user->tg_id === null ? 'true' : 'false' }};

            container.addEventListener('click', function(e) {
                const btn = e.target.closest('.handle-track');
                if (!btn) return;

                axios.post("/track/handle", {
                    trackable_type: btn.getAttribute('data-trackable-type'),
                    trackable_id: btn.getAttribute('data-trackable-id')
                }).then(r => {
                    pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                    if (!r.data.success) return;

                    if (r.data.tracking) {
                        btn.textContent = "{{ __('Untrack price') }}";

                        if (needsTgAuth && !window.tgDontAsk) window.dispatchEvent(new CustomEvent(
                            'open-modal', {
                                detail: 'tg-auth'
                            }));
                    } else btn.textContent = "{{ __('Track price') }}";
                }).catch(err => console.error(err));
            });
        });
    </script>
</x-profile.section>
