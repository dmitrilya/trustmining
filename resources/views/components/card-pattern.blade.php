<div class="absolute inset-0 opacity-65 dark:opacity-60 pointer-events-none z-0 select-none"
    :style="`--pattern-color: ${getPrizeRarityClasses(prize.chance, index).patternColor}`">
    <svg xmlns="http://w3.org" class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
        <g x-html="getPrizeRarityClasses(prize.chance, index).circuitHtml"></g>
    </svg>
</div>
