@props(['name', 'label' => null, 'type' => 'date', 'min' => null, 'max' => null, 'value' => null, 'disabled' => false])

@php
    $minDateValue = null;
    if ($min === 'today') {
        $minDateValue = now()->startOfDay()->timestamp * 1000;
    } elseif ($min) {
        $minDateValue = (is_numeric($min) ? $min : strtotime($min)) * 1000;
    }

    $maxDateValue = $max ? (is_numeric($max) ? $max : strtotime($max)) * 1000 : null;

    $initialTimestamp = $value ? (is_numeric($value) ? $value : strtotime($value)) : null;
@endphp

<div x-data="datetimePicker({
    type: '{{ $type }}',
    minTimestamp: {{ $minDateValue ?? 'null' }},
    maxTimestamp: {{ $maxDateValue ?? 'null' }},
    initialTimestamp: {{ $initialTimestamp ? $initialTimestamp * 1000 : 'null' }}
})" x-init="init()" class="w-full relative">
    @if ($label)
        <x-inputs.input-label class="mb-1" for="{{ $name }}_display" :value="__($label)" />
    @endif

    <input type="hidden" name="{{ $name }}" :value="getFormattedValue()">

    <div class="relative w-full">
        <input type="text" id="{{ $name }}_display" {{ $disabled ? 'disabled' : '' }} readonly :value="getDisplayValue()" @click="open = !open"
            class="py-1.5 px-10 block w-full rounded-lg shadow-sm shadow-logo-color bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-200 border-0 ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus:ring-indigo-500 dark:focus:ring-indigo-500 focus:outline-none disabled:opacity-25">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-600 dark:text-slate-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        @if (!$disabled)
            <template x-if="selectedDate">
                <button type="button" @click="clear()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-600 dark:hover:text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </template>
        @endif
    </div>

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

    <div x-show="open" x-transition x-on:click.outside="open = false"
        class="absolute w-full max-w-xs z-50 bottom-10 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 backdrop-blur-xl rounded-xl shadow-lg shadow-logo-color p-2 sm:p-4"
        style="display: none;">
        <div class="flex items-center justify-between mb-3">
            <button type="button" @click="prevMonth()"
                class="w-8 h-8 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400">&lt;</button>
            <span class="text-sm text-slate-800 dark:text-slate-200" x-text="monthNames[month] + ' ' + year"></span>
            <button type="button" @click="nextMonth()"
                class="w-8 h-8 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400">&gt;</button>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">
            <div>Пн</div>
            <div>Вт</div>
            <div>Ср</div>
            <div>Чт</div>
            <div>Пт</div>
            <div>Сб</div>
            <div>Вс</div>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center text-sm" style="min-height: 192px">
            <template x-for="blank in blanks">
                <div class="p-1"></div>
            </template>

            <template x-for="date in daysInMonth">
                <button type="button" @click="isDisabled(date) ? null : selectDay(date)" :disabled="isDisabled(date)" class="p-1 rounded-lg transition"
                    :class="{
                        'text-slate-200 bg-indigo-600 hover:bg-indigo-700': isSelected(date),
                        'text-indigo-500 font-bold border border-indigo-600 hover:bg-slate-100 dark:hover:bg-slate-800': isToday(date) && !isSelected(date) && !
                            isDisabled(date),
                        'text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 cursor-pointer':
                            !isToday(date) && !isSelected(date) && !isDisabled(date),
                        'text-slate-800 dark:text-slate-200 cursor-not-allowed opacity-20': isDisabled(date)
                    }"
                    x-text="date"></button>
            </template>
        </div>

        <template x-if="config.type === 'datetime'">
            <div class="mt-3 pt-3 border-t border-slate-300 dark:border-slate-700 flex items-center justify-center gap-2">
                <div class="flex items-center gap-1">
                    <input type="number" min="0" max="23" x-model.number="hour" @change="updateTime()"
                        class="w-12 text-center text-sm bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 rounded-lg p-1 focus:outline-none focus:ring-1 ring-inset focus:ring-indigo-500">
                    <span class="text-slate-500">:</span>
                    <input type="number" min="0" max="59" x-model.number="minute" @change="updateTime()"
                        class="w-12 text-center text-sm bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 rounded-lg p-1 focus:outline-none focus:ring-1 ring-inset focus:ring-indigo-500">
                </div>
                <button type="button" @click="open = false"
                    class="ml-auto text-xs font-bold text-indigo-500 hover:text-indigo-600 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-600 px-2.5 py-1.5 rounded-lg">ОК</button>
            </div>
        </template>
    </div>
</div>

<script>
    if (typeof window.datetimePicker === 'undefined') {
        window.datetimePicker = function(config) {
            return {
                open: false,
                config: config,
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                viewDate: new Date(),
                selectedDate: null,
                month: 0,
                year: 0,
                hour: 12,
                minute: 0,
                daysInMonth: [],
                blanks: [],

                init() {
                    if (this.config.initialTimestamp) {
                        this.selectedDate = new Date(this.config.initialTimestamp);
                        this.viewDate = new Date(this.config.initialTimestamp);
                        this.hour = this.selectedDate.getHours();
                        this.minute = this.selectedDate.getMinutes();
                    }
                    this.month = this.viewDate.getMonth();
                    this.year = this.viewDate.getFullYear();
                    this.hour = this.viewDate.getHours();
                    this.minute = this.viewDate.getMinutes();
                    this.getDays();
                },

                getDays() {
                    let days = new Date(this.year, this.month + 1, 0).getDate();
                    this.daysInMonth = Array.from({
                        length: days
                    }, (_, i) => i + 1);
                    let firstDayIndex = new Date(this.year, this.month, 1).getDay();
                    let blankCount = firstDayIndex === 0 ? 6 : firstDayIndex - 1;
                    this.blanks = Array.from({
                        length: blankCount
                    });
                },

                prevMonth() {
                    if (this.month === 0) {
                        this.month = 11;
                        this.year--;
                    } else {
                        this.month--;
                    }
                    this.getDays();
                },

                nextMonth() {
                    if (this.month === 11) {
                        this.month = 0;
                        this.year++;
                    } else {
                        this.month++;
                    }
                    this.getDays();
                },

                isDisabled(day) {
                    let currentCellDate = new Date(this.year, this.month, day, 23, 59, 59).getTime();
                    let currentCellDateMin = new Date(this.year, this.month, day, 0, 0, 0).getTime();
                    if (this.config.minTimestamp && currentCellDate < this.config.minTimestamp) return true;
                    if (this.config.maxTimestamp && currentCellDateMin > this.config.maxTimestamp) return true;
                    return false;
                },

                selectDay(day) {
                    this.selectedDate = new Date(this.year, this.month, day, this.hour, this.minute);
                    if (this.config.type === 'date') this.open = false;
                },

                updateTime() {
                    if (this.hour > 23) this.hour = 23;
                    if (this.hour < 0) this.hour = 0;
                    if (this.minute > 59) this.minute = 59;
                    if (this.minute < 0) this.minute = 0;

                    let baseDate = this.selectedDate || new Date();

                    this.selectedDate = new Date(
                        baseDate.getFullYear(),
                        baseDate.getMonth(),
                        baseDate.getDate(),
                        this.hour,
                        this.minute
                    );
                },

                isSelected(day) {
                    if (!this.selectedDate) return false;
                    return this.selectedDate.getDate() === day &&
                        this.selectedDate.getMonth() === this.month &&
                        this.selectedDate.getFullYear() === this.year;
                },

                isToday(day) {
                    let today = new Date();
                    return today.getDate() === day && today.getMonth() === this.month && today.getFullYear() === this.year;
                },

                getDisplayValue() {
                    if (!this.selectedDate || this.selectedDate == new Date()) return '{{ __('Immediately') }}';

                    let options = this.config.type === 'datetime' ? {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    } : {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    };

                    return this.selectedDate.toLocaleString('ru-RU', options);
                },

                getFormattedValue() {
                    if (!this.selectedDate) return '';

                    let d = this.selectedDate;
                    let pad = (num) => String(num).padStart(2, '0');

                    let year = d.getUTCFullYear();
                    let month = pad(d.getUTCMonth() + 1);
                    let day = pad(d.getUTCDate());
                    let hours = pad(d.getUTCHours());
                    let minutes = pad(d.getUTCMinutes());

                    return this.config.type === 'datetime' ?
                        `${year}-${month}-${day} ${hours}:${minutes}:00` :
                        `${year}-${month}-${day}`;
                },

                clear() {
                    this.selectedDate = null;
                    this.open = false;
                }
            }
        }
    }
</script>
