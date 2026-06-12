@props(['name', 'max' => null, 'label', 'multiple' => false, 'accept' => null, 'id' => null])

<div class="w-full mt-1" x-data="{
    filesCount: 0,
    maxFiles: {{ $max ? $max : 'null' }},
    fileName: '',
    isMultiple: {{ $multiple ? 'true' : 'false' }},
    isDragOver: false,
    allowedTypes: '{{ $accept }}',
    id: '{{ $id }}',

    isValidType(file) {
        if (!this.allowedTypes) return true;

        const extensions = this.allowedTypes.split(',').map(ext => ext.trim().toLowerCase());
        const fileName = file.name.toLowerCase();

        return extensions.some(ext => fileName.endsWith(ext));
    },

    updateFiles(event) {
        if (typeof validation !== 'undefined' && validation['{{ $name }}']) delete validation['{{ $name }}'];

        let rawFiles = event.target.files || event.dataTransfer.files;

        const validFilesArray = [];

        for (let i = 0; i < rawFiles.length; i++) {
            if (this.isValidType(rawFiles[i])) validFilesArray.push(rawFiles[i]);
            else {
                this.resetInput();
                return window.pushToastAlert('{{ __('Invalid file format. Allowed only') }}: ' + this.allowedTypes, 'error');
            }
        }

        if (this.isMultiple) {
            if (this.maxFiles && validFilesArray.length > this.maxFiles) {
                this.resetInput();
                return window.pushToastAlert('{{ __('validation.max.array', ['max' => $max]) }}', 'error');
            }
        } else if (validFilesArray.length > 1) validFilesArray.splice(1);

        const dataTransfer = new DataTransfer();
        validFilesArray.forEach(file => dataTransfer.items.add(file));

        this.filesCount = dataTransfer.files.length;
        if (this.filesCount > 0) this.fileName = dataTransfer.files[0].name;
        else this.fileName = '';

        this.$refs.fileInput.files = dataTransfer.files;
    },

    resetInput() {
        this.$refs.fileInput.value = null;
        this.filesCount = 0;
        this.fileName = '';
    },

    handleClearFiles(event) {
        if (event.detail.id === this.id) {
            this.resetInput();
        }
    },

    getLabelText() {
        if (this.filesCount === 0)
            return this.isDragOver ? '{{ __('Release files for download') }}' : '{{ __('Select files or drag them here') }}';

        if (this.isMultiple) return '{{ __('Selected files') }}: ' + this.filesCount;
        else return '{{ __('Selected file') }}: ' + this.fileName;
    }
}" @clear-files.window="handleClearFiles($event)">
    <label
        class="flex flex-col items-center justify-center w-full h-28 sm:h-32 border-2 border-dashed rounded-xl cursor-pointer transition-colors group"
        :class="isDragOver ? 'border-indigo-500' :
            'border-slate-500 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500'"
        @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; updateFiles($event)">

        <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center pointer-events-none w-full">
            <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-2 sm:mb-3 transition-colors"
                :class="isDragOver ? 'text-indigo-500' : 'text-slate-400 group-hover:text-indigo-500'" aria-hidden="true"
                xmlns="http://w3.org" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5.016 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
            </svg>

            <p class="text-xxs xs:text-xs sm:text-sm transition-colors truncate max-w-full px-2"
                :class="isDragOver ? 'text-indigo-500' : 'text-slate-600 dark:text-slate-400 group-hover:text-indigo-500'"
                x-text="getLabelText()"></p>
            <p class="text-xs text-slate-500 mt-2" x-show="filesCount === 0">{{ $label }}</p>
        </div>

        <input id="{{ $id }}" type="file" x-ref="fileInput" name="{{ $name }}"
            @if ($accept) accept="{{ $accept }}" @endif
            @if ($multiple) multiple @endif {{ $attributes->merge(['class' => 'sr-only']) }}
            @change="updateFiles($event)" />
    </label>
</div>
