<?php

return [

    'accepted'             => 'Este campo debe ser aceptado.',
    'active_url'           => 'La URL no es válida.',
    'after'                => 'La fecha debe ser posterior a :date.',
    'after_or_equal'       => 'La fecha debe ser posterior o igual a :date.',
    'alpha'                => 'Este campo solo puede contener letras.',
    'alpha_dash'           => 'Solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'Solo puede contener letras y números.',
    'array'                => 'Debe ser un arreglo.',
    'before'               => 'Debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'Debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'Debe estar entre :min y :max.',
        'file'    => 'Debe pesar entre :min y :max kilobytes.',
        'string'  => 'Debe tener entre :min y :max caracteres.',
        'array'   => 'Debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'Debe ser verdadero o falso.',
    'confirmed'            => 'La confirmación no coincide.',
    'date'                 => 'No es una fecha válida.',
    'date_format'          => 'No coincide con el formato :format.',
    'different'            => 'Este campo y :other deben ser diferentes.',
    'digits'               => 'Debe tener :digits dígitos.',
    'digits_between'       => 'Debe tener entre :min y :max dígitos.',
    'email'                => 'Debe ser un correo electrónico válido.',
    'exists'               => 'El valor seleccionado no es válido.',
    'file'                 => 'Debe ser un archivo.',
    'filled'               => 'Este campo es obligatorio.',
    'image'                => 'Debe ser una imagen.',
    'in'                   => 'El valor seleccionado no es válido.',
    'integer'              => 'Debe ser un número entero.',
    'ip'                   => 'Debe ser una dirección IP válida.',
    'json'                 => 'Debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => 'No debe ser mayor que :max.',
        'file'    => 'No debe pesar más de :max kilobytes.',
        'string'  => 'No debe tener más de :max caracteres.',
        'array'   => 'No debe tener más de :max elementos.',
    ],
    'mimes'                => 'Debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'Debe ser al menos :min.',
        'file'    => 'Debe pesar al menos :min kilobytes.',
        'string'  => 'Debe tener al menos :min caracteres.',
        'array'   => 'Debe tener al menos :min elementos.',
    ],
    'not_in'               => 'El valor seleccionado no es válido.',
    'numeric'              => 'Debe ser un número.',
    'required'             => 'Este campo es obligatorio.',
    'same'                 => 'Este campo y :other deben coincidir.',
    'uploaded'             => 'Error al subir el archivo.',
    'unique'               => 'El valor ya está registrado.',
    'custom' => [
        'teacher_user' => [
            'unique' => 'El usuario de maestro ya está registrado.',
        ],
        'administrative_user' => [
            'unique' => 'El usuario administrativo ya existe.',
        ],
        'user' => [
            'unique' => 'Este usuario ya está siendo usado.',
        ],
         'start_date' => [
        'required' => 'La fecha de inicio es obligatoria.',
        'date' => 'La fecha de inicio no es válida.',
    ],

    'end_date' => [
        'required' => 'La fecha de fin es obligatoria.',
        'date' => 'La fecha de fin no es válida.',
        'after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
    ],

    'day_of_week' => [
        'required' => 'Seleccione un día de la semana.',
    ],

    'start_time' => [
        'required' => 'La hora de inicio es obligatoria.',
        'date_format' => 'La hora de inicio debe estar en formato HH:mm.',
        'after' => 'La hora de inicio debe ser antes de la hora de fin.',
    ],

    'end_time' => [
        'required' => 'La hora de fin es obligatoria.',
        'date_format' => 'La hora de fin debe estar en formato HH:mm.',
        'after' => 'La hora de fin debe ser posterior a la hora de inicio.',
    ],
    ],


    'attributes' => [
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'name' => 'nombre',
        'email' => 'correo electrónico',
    ],

];


