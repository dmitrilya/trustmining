<div class="space-y-1.5">
    <div class="relative w-full h-2">
        @php
            $sortedThresholds = $factor['thresholds'];
            if ($factor['type'] === 'threshold_reverse') {
                arsort($sortedThresholds);
            } else {
                asort($sortedThresholds);
            }

            $gradients = $factor['type'] === 'threshold_reverse' ? ['#10b981', '#f59e0b', '#f43f5e'] : ['#f43f5e', '#f59e0b', '#10b981'];

            $thresholdKeys = array_keys($sortedThresholds);
            $matchedIndex = array_search($factor['matched_threshold'], $thresholdKeys);
            $count = count($thresholdKeys);
        @endphp

        <div class="w-full h-full flex rounded-full"
            style="background: linear-gradient(to right, {{ $gradients[0] }}, {{ $gradients[1] }}, {{ $gradients[2] }});">

            @foreach ($thresholdKeys as $i => $threshold)
                @php
                    $segmentWidth = 100 / $count;
                    $isActive = $i === $matchedIndex;
                @endphp

                <div class="relative h-full transition duration-300 {{ $loop->first ? 'border-r rounded-l-full' : ($loop->last ? 'border-l rounded-r-full' : 'border-x') }} border-slate-300 dark:border-slate-700 {{ !$isActive ? 'bg-slate-200/75 dark:bg-slate-900/75 z-0' : 'z-10' }}"
                    style="width: {{ $segmentWidth }}%;">

                    @if ($isActive)
                        <div class="absolute -top-5 left-1/2 -translate-x-1/2 text-xs font-mono text-slate-600 dark:text-slate-400">
                            {{ $factor['value'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-between text-xxs font-mono text-slate-500 px-0.5">
        <span>{{ $thresholdKeys[0] }}</span>
        <span>{{ end($thresholdKeys) }}</span>
    </div>
</div>
