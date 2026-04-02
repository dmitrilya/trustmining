<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute должен быть принят.',
    'accepted_if' => ':attribute должен быть принят, когда :other равен :value.',
    'active_url' => ':attribute не является корректным URL‑адресом.',
    'after' => ':attribute должен быть датой после :date.',
    'after_or_equal' => ':attribute должен быть датой после или равной :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и знаки подчёркивания.',
    'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'ascii' => ':attribute должен содержать только однобайтовые буквенно‑цифровые символы и символы.',
    'before' => ':attribute должен быть датой до :date.',
    'before_or_equal' => ':attribute должен быть датой до или равной :date.',
    'between' => [
        'array' => ':attribute должен содержать от :min до :max элементов.',
        'file' => 'Размер :attribute должен быть от :min до :max килобайт.',
        'numeric' => ':attribute должен находиться в диапазоне от :min до :max.',
        'string' => ':attribute должен содержать от :min до :max символов.'
    ],
    'boolean' => 'Поле :attribute должно иметь значение „истина“ или „ложь“ (true/false).',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Неверный пароль.',
    'date' => ':attribute не является корректной датой.',
    'date_equals' => ':attribute должен быть датой, равной :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'decimal' => ':attribute должен иметь :decimal знаков после запятой.',
    'declined' => ':attribute должен быть отклонён.',
    'declined_if' => ':attribute должен быть отклонён, когда :other равен :value.',
    'different' => ':attribute и :other должны различаться.',
    'digits' => ':attribute должен состоять из :digits цифр.',
    'digits_between' => ':attribute должен содержать от :min до :max цифр.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
    'doesnt_end_with' => ':attribute не может заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => ':attribute не может начинаться с одного из следующих значений: :values.',
    'email' => ':attribute должен быть корректным адресом электронной почты.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих значений: :values.',
    'enum' => 'Выбранный :attribute недопустим.',
    'exists' => 'Выбранный :attribute недопустим.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => ':attribute должен содержать более :value элементов.',
        'file' => 'Размер :attribute должен превышать :value килобайт.',
        'numeric' => ':attribute должен быть больше :value.',
        'string' => ':attribute должен содержать больше :value символов.'
    ],
    'gte' => [
        'array' => ':attribute должен содержать :value элементов или больше.',
        'file' => 'Размер :attribute должен быть :value килобайт или больше.',
        'numeric' => ':attribute должен быть больше или равен :value.',
        'string' => ':attribute должен содержать :value символов или больше.'
    ],
    'image' => ':attribute должен быть изображением.',
    'in' => 'Выбранный :attribute недопустим.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть корректным IP‑адресом.',
    'ipv4' => ':attribute должен быть корректным IPv4‑адресом.',
    'ipv6' => ':attribute должен быть корректным IPv6‑адресом.',
    'json' => ':attribute должен быть корректной JSON‑строкой.',
    'lowercase' => ':attribute должен быть в нижнем регистре.',
    'lt' => [
        'array' => ':attribute должен содержать менее :value элементов.',
        'file' => 'Размер :attribute должен быть менее :value килобайт.',
        'numeric' => ':attribute должен быть меньше :value.',
        'string' => ':attribute должен содержать менее :value символов.'
    ],
    'lte' => [
        'array' => ':attribute не должен содержать более :value элементов.',
        'file' => 'Размер :attribute должен быть не более :value килобайт.',
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'string' => ':attribute должен содержать не более :value символов.'
    ],
    'mac_address' => ':attribute должен быть корректным MAC‑адресом.',
    'max' => [
        'array' => 'Не более :max элементов.',
        'file' => 'Файл не должен превышать :size КБ.',
        'numeric' => ':attribute не должен превышать :max.',
        'string' => 'Длина :attribute не должна превышать :max символов.'
    ],
    'max_digits' => ':attribute не должен содержать более :max цифр.',
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'array' => ':attribute должен содержать как минимум :min элементов.',
        'file' => 'Размер :attribute должен быть не менее :min килобайт.',
        'numeric' => ':attribute должен быть не меньше :min.',
        'string' => ':attribute должен быть не короче :min символов.'
    ],
    'min_digits' => ':attribute должен содержать как минимум :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, когда :other равен :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если только :other не равен :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, когда присутствует :values.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, когда присутствуют :values.',
    'multiple_of' => ':attribute должен быть кратным :value.',
    'not_in' => 'Выбранный :attribute недопустим.',
    'not_regex' => 'Формат :attribute недопустим.',
    'numeric' => ':attribute должен быть числом.',
    'password' => [
        'letters' => ':attribute должен содержать как минимум одну букву.',
        'mixed' => ':attribute должен содержать как минимум одну заглавную и одну строчную букву.',
        'numbers' => ':attribute должен содержать как минимум одну цифру.',
        'symbols' => ':attribute должен содержать как минимум один символ.',
        'uncompromised' => 'Указанный :attribute был обнаружен в утечке данных. Пожалуйста, выберите другой :attribute.'
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равен :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если только :other не входит в :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Формат :attribute недопустим.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равен :value.',
    'required_if_accepted' => 'Поле :attribute обязательно для заполнения, когда :other принят.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, если :other не входит в :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда присутствует :values.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, когда присутствуют :values.',
    'required_without' => 'Поле :attribute обязательно для заполнения, когда :values отсутствует.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни один из :values не присутствует.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'array' => ':attribute должен содержать :size элементов.',
        'file' => 'Размер :attribute должен составлять :size килобайт.',
        'numeric' => ':attribute должен быть равен :size.',
        'string' => ':attribute должен содержать :size символов.'
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих значений: :values.',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть корректным часовым поясом.',
    'unique' => ':attribute уже используется.',
    'uploaded' => 'Не удалось загрузить :attribute.',
    'uppercase' => ':attribute должен быть в верхнем регистре.',
    'url' => ':attribute должен быть корректным URL‑адресом.',
    'ulid' => ':attribute должен быть корректным ULID.',
    'uuid' => ':attribute должен быть корректным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
