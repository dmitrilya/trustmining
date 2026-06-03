<x-app-layout
    title="{{ request()->routeIs('terms') ? 'Пользовательское соглашение - условия использования TrustMining' : 'Политика конфиденциальности - условия обработки данных TrustMining' }}"
    description="{{ request()->routeIs('terms') ? 'Пользовательское соглашение TrustMining: правила использования платформы, права и обязанности пользователей, ответственность сторон и условия работы с сервисами сайта' : 'Политика конфиденциальности TrustMining: правила сбора, хранения и защиты персональной информации пользователей, использование файлов cookie и гарантии безопасности данных' }}">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div id="doc-wrapper" class="mx-auto px-0 space-y-4" style="max-width:596px"></div>

        <script src="//mozilla.github.io/pdf.js/build/pdf.mjs" type="module"></script>

        <script type="module">
            var url = "/storage/{{ request()->routeIs('privacy') ? 'documents/privacy.pdf' : 'documents/agreement.pdf' }}";

            var currPage = 1;
            var numPages = 0;
            var thePDF = null;
            var wrapper = document.getElementById('doc-wrapper');

            var {
                pdfjsLib
            } = globalThis;

            pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.mjs';

            var loadingTask = pdfjsLib.getDocument({ url: url });
            loadingTask.promise.then(function(pdf) {
                thePDF = pdf;
                numPages = pdf.numPages;
                pdf.getPage(1).then(handlePages);
            });

            function handlePages(page) {
                var viewport = page.getViewport({
                    scale: 1.5
                });

                var canvas = document.createElement("canvas");
                canvas.style.display = "block";
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.style.width = "100%";
                canvas.style.height = "100%";

                page.render({
                    canvasContext: context,
                    viewport: viewport
                });

                var w1 = document.createElement('div');
                w1.className = "overflow-hidden rounded-2xl shadow-lg shadow-logo-color border border-slate-300";
                w1.append(canvas);
                wrapper.appendChild(w1);

                currPage++;
                if (thePDF !== null && currPage <= numPages) {
                    thePDF.getPage(currPage).then(handlePages);
                }
            }
        </script>
    </div>
</x-app-layout>
