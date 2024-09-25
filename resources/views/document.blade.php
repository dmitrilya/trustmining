<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div id="doc-wrapper" class="mx-auto px-0 space-y-4" style="max-width:596px"></div>

        <script src="//mozilla.github.io/pdf.js/build/pdf.mjs" type="module"></script>

        <script type="module">
            var url = "/storage/{{ request()->path }}";

            var currPage = 1;
            var numPages = 0;
            var thePDF = null;
            var wrapper = document.getElementById('doc-wrapper');

            // Loaded via <script> tag, create shortcut to access PDF.js exports.
            var {
                pdfjsLib
            } = globalThis;

            // The workerSrc property shall be specified.
            pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.mjs';

            // Asynchronous download of PDF
            var loadingTask = pdfjsLib.getDocument(url);
            loadingTask.promise.then(function(pdf) {

                //Set PDFJS global object (so we can easily access in our page functions
                thePDF = pdf;

                //How many pages it has
                numPages = pdf.numPages;

                //Start with first page
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
                w1.className = "overflow-hidden rounded-2xl shadow-md border border-gray-200";
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
