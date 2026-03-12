<div x-data="{ show: false }" class="ql-snow">
    <h2 class="font-bold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Description') }}</h2>

    <div itemprop="description" style="overflow-y: hidden; max-height: 5rem"
        :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '5rem' }"
        class="ql-editor mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400 transition-all ease-in-out">
            <p>Газопоршневая электростанция (ГПЭС) <b>{{ $model->name }}</b> от ведущего мирового бренда
                <b>{{ $brand->name }}</b> (страна производства — <b>{{ __($brand->country) }}</b>) представляет собой
                высокотехнологичное решение для создания систем автономного и резервного энергоснабжения. Данная
                установка спроектирована для обеспечения максимальной энергетической независимости промышленных
                предприятий, коммерческих объектов и крупных майнинг-отелей.</p>
            <p><br></p>
            <h2>Технические характеристики и мощность</h2>
            <p>Модель {{ $model->name }} отличается высокими эксплуатационными показателями и адаптивностью к сложным
                условиям работы.</p>
            <p><br></p>
            <ol>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Максимальная мощность:</b></span> Станция способна
                    выдавать до <b>{{ $model->max_power }} {{ __('kW/h') }}</b>, что позволяет запитывать энергоемкое
                    оборудование без просадок напряжения.</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Электрические параметры:</b></span> Установка
                    генерирует ток в {{ $model->phases }}-фазном режиме, обеспечивая стабильную синусоиду и частоту,
                    необходимую для чувствительной электроники.</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Экономичность:</b></span> Продуманная система
                    смесеобразования позволяет достичь оптимизированного расхода топлива. Расход газа составляет
                    <b>{{ $model->fuel_consumption }}</b>, что делает стоимость одного кВт*ч значительно ниже, чем при
                    использовании магистральных сетей или дизельных аналогов.</li>
            </ol>
            <p><br></p>
            <h2>Силовая установка: Сердце системы</h2>
            <p>Надежность электростанции напрямую зависит от характеристик двигателя. В данной модели применен
                промышленный газопоршневой двигатель <b>{{ $model->gpuEngineModel->name }}</b> от легендарного
                производителя <b>{{ $model->gpuEngineModel->gpuEngineBrand->name }}</b>
                (<b>{{ $model->gpuEngineModel->gpuEngineBrand->country }}</b>).</p>
            <p><br></p>
            <h3>Двигатель обладает следующими конструктивными особенностями:</h3>
            <ol>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Рабочий объем:</b></span>
                    <b>{{ $model->gpuEngineModel->volume }}</b>, что гарантирует высокий крутящий момент и стабильность
                    под нагрузкой.</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Конфигурация:</b></span> Двигатель имеет
                    <b>{{ $model->gpuEngineModel->cylinders }}</b> цилиндров, расположенных таким образом, чтобы
                    минимизировать вибрации и механический износ.</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Скорость работы:</b></span> Частота вращения составляет
                    <b>{{ $model->gpuEngineModel->rpm }}</b> об/мин. Это оптимальный режим для длительной непрерывной
                    эксплуатации (24/7), обеспечивающий увеличенный межремонтный интервал (моторесурс).</li>
            </ol>
            <p><br></p>
            <h2>Преимущества газопоршневой технологии <b>{{ $brand->name }}</b></h2>
            <p><br></p>
            <ol>
                <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Низкая себестоимость энергии:</b></span> Использование
                    природного газа (или сопутствующего нефтяного газа) позволяет сократить затраты на электроэнергию в
                    2-3 раза по сравнению с тарифами электросетей.</li>
                <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Экологичность:</b></span> Газопоршневые двигатели
                    <b>{{ $model->gpuEngineModel->gpuEngineBrand->name }}</b> соответствуют строгим международным
                    экологическим стандартам по выбросам NOx и CO.</li>
                <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Возможность когенерации:</b></span> Станция
                    <b>{{ $model->name }}</b> может быть доукомплектована системой утилизации тепла, что позволит
                    бесплатно получать тепловую энергию для отопления помещений или технологических нужд.</li>
                <li data-list="ordered"><span class="ql-ui" contenteditable="false"></span><span
                        class="ql-color-secondary-text-color"><b>Долговечность:</b></span> Промышленные компоненты и
                    прецизионная сборка в <b>{{ $brand->country }}</b> обеспечивают срок службы установки в десятки
                    тысяч моточасов до капитального ремонта.</li>
            </ol>
            <p><br></p>
            <h2>Безопасность и управление</h2>
            <p>Станция оснащена современной микропроцессорной панелью управления, которая в автоматическом режиме
                контролирует все критические параметры: давление газа, температуру охлаждающей жидкости, уровень масла и
                качество выходного тока. Система защиты мгновенно реагирует на любые отклонения, предотвращая выход
                оборудования из строя.</p>
            <p><br></p>
            <h2>Сферы применения</h2>
            <p>Благодаря сочетанию высокой мощности {{ $model->max_power }} {{ __('kW/h') }} и надежного двигателя {{ $model->gpuEngineModel->name }},
                данная ГПУ является идеальным выбором для:</p>
            <ol>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Производственных цехов и
                    заводов;</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Крупных центров обработки
                    данных (ЦОД);</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Объектов нефтегазового
                    сектора;</li>
                <li data-list="bullet"><span class="ql-ui" contenteditable="false"></span>Майнинговых ферм, требующих
                    стабильной и дешевой электроэнергии.</li>
            </ol>
            <p><br></p>
            <h2>Резюме</h2>
            <p>Выбирая газопоршневую электростанцию <b>{{ $brand->name }} {{ $model->name }}</b>, вы инвестируете в
                надежный актив, который обеспечит ваше предприятие энергией на долгие годы. Это проверенное временем
                решение, сочетающее в себе инженерную школу и современные технологии энергоэффективности.</p>
    </div>

    <button @click="show = !show"
        class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
