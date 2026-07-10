@props(['targetWidth' => 1024])

<script>
    (() => {
        const currentScript = document.currentScript;
        if (!currentScript) return;

        const mediaQuery = window.matchMedia('(min-width: {{ $targetWidth }}px)');
        let inlineBlock = null;

        function restartAikodexWidget() {
            const oldScript = document.querySelector('script[src*="aikodex-widget"]');
            if (oldScript) {
                oldScript.remove();
            }

            const renderedElements = document.querySelectorAll('[class*="aikodex"], [id*="aikodex"]');
            renderedElements.forEach(el => {
                if (!el.hasAttribute('data-aikodex-inline')) {
                    el.remove();
                }
            });

            const newScript = document.createElement('script');
            newScript.src = "https://aikodex-widget.s3.twcstorage.ru/widget.js";
            newScript.async = true;

            newScript.setAttribute('data-api-base', 'https://app.aikodex.ru/api/widget');
            newScript.setAttribute('data-widget-key', 'wk_live_-5REJnWb_qV__87pwjIg5A8yGMz4Cgkj');
            newScript.setAttribute('data-accent', '#40ff9f');
            newScript.setAttribute('data-greeting',
                '{{ __('Ask any legal question and get a free consultation in 1 minute') }}');
            newScript.setAttribute('data-auto-open', 'scroll');
            newScript.setAttribute('data-auto-open-value', '20');

            document.body.appendChild(newScript);
        }

        function handleScreenChange(e) {
            let stateChanged = false;

            if (e.matches) {
                if (!inlineBlock) {
                    inlineBlock = document.createElement('div');
                    inlineBlock.setAttribute('data-aikodex-inline', '');
                    inlineBlock.classList.add('bg-white/40', 'dark:bg-slate-900/40', 'border', 'border-slate-300', 'dark:border-slate-700', 'shadow', 'shadow-logo-color', 'rounded-xl');

                    currentScript.after(inlineBlock);
                    stateChanged = true;
                }
            } else {
                if (inlineBlock) {
                    inlineBlock.remove();
                    inlineBlock = null;
                    stateChanged = true;
                }
            }

            if (stateChanged) restartAikodexWidget();
        }

        handleScreenChange(mediaQuery);

        mediaQuery.addEventListener('change', handleScreenChange);
    })();
</script>
