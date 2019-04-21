<?php

return [
    'accepted' => ':attribute mora biti prihvacen.',
    'active_url' => ':attribute nije validan URL.',
    'after' => ':attribute mora biti datum nakon :date.',
    'after_or_equal' => ':attribute mora biti datum veci ili jednak od :date.',
    'alpha' => ':attribute moze sadrzati samo slova.',
    'alpha_dash' => ':attribute moze sadrzati samo slova, brojeve, crte i donje crte.',
    'alpha_num' => ':attribute moze sadrzati samo slova i brojeve.',
    'array' => ':attribute mora biti niz.',
    'before' => ':attribute mora biti datum prije :date.',
    'before_or_equal' => ':attribute mora biti datum manji ili jednak od :date.',
    'between' => [
        'numeric' => ':attribute mora biti izmedju :min i :max.',
        'file' => ':attribute mora biti izmedju :min i :max kilobajta.',
        'string' => ':attribute mora biti izmedju :min i :max karaktera.',
        'array' => ':attribute mora imati izmedju :min i :max elemenata.',
    ],
    'boolean' => ':attribute mora biti \'tacno\' ili \'netacno\'.',
    'confirmed' => 'Ponovljena vrijednost polja :attribute se ne poklapa.',
    'date' => ':attribute nije validan datum.',
    'date_equals' => ':attribute mora biti datum jednak :date.',
    'date_format' => ':attribute se ne poklapa sa formatom :format.',
    'different' => ':attribute i :other moraju biti razliciti.',
    'digits' => ':attribute mora imati duzinu od :digits cifara.',
    'digits_between' => ':attribute mora biti izmedju :min i :max cifara.',
    'dimensions' => ':attribute ima nevalidne dimenzije slike.',
    'distinct' => ':attribute ima vrijednost koja vec postoji.',
    'email' => ':attribute mora biti validna email adresa.',
    'exists' => ':attribute nije validan.',
    'file' => ':attribute mora biti fajl.',
    'filled' => ':attribute mora imati vrijednost.',
    'gt' => [
        'numeric' => ':attribute mora biti veci od :value.',
        'file' => ':attribute mora biti veci od :value kilobajta.',
        'string' => ':attribute mora biti veci od :value karaktera.',
        'array' => ':attribute mora imati vise od :value elemenata.',
    ],
    'gte' => [
        'numeric' => ':attribute mora biti veci ili jednak :value.',
        'file' => ':attribute mora biti veci ili jednak :value kilobajta.',
        'string' => ':attribute mora biti veci ili jednak :value karaktera.',
        'array' => ':attribute mora imati :value ili vise elemenata.',
    ],
    'image' => ':attribute mora biti slika.',
    'in' => ':attribute nije validan.',
    'in_array' => ':attribute ne postoji u :other.',
    'integer' => ':attribute mora biti cio broj.',
    'ip' => ':attribute mora biti validna IP adresa.',
    'ipv4' => ':attribute mora biti validna IPv4 adresa.',
    'ipv6' => ':attribute mora biti validna IPv6 adresa.',
    'json' => ':attribute mora biti validan JSON string.',
    'lt' => [
        'numeric' => ':attribute mora biti manji od :value.',
        'file' => ':attribute mora biti manji od :value kilobajta.',
        'string' => ':attribute mora biti manji od :value karaktera.',
        'array' => ':attribute mora imati manje od :value elemenata.',
    ],
    'lte' => [
        'numeric' => ':attribute mora biti manji ili jednak od :value.',
        'file' => ':attribute mora biti manji ili jednak od :value kilobajta.',
        'string' => ':attribute mora biti manji ili jednak od :value karaktera.',
        'array' => ':attribute moze imati najvise :value elemenata.',
    ],
    'max' => [
        'numeric' => ':attribute ne smije biti veci od :max.',
        'file' => ':attribute ne smije biti veci od :max kilobajta.',
        'string' => ':attribute ne smije biti veci od :max karaktera.',
        'array' => ':attribute ne smije imati vise od :max elemenata.',
    ],
    'mimes' => ':attribute mora biti fajl tipa: :values.',
    'mimetypes' => ':attribute mora biti fajl tipa: :values.',
    'min' => [
        'numeric' => ':attribute mora biti bar :min.',
        'file' => ':attribute mora biti bar :min kilobajta.',
        'string' => ':attribute mora biti bar :min karaktera.',
        'array' => ':attribute mora sadrzati barem :min elemenata.',
    ],
    'not_in' => ':attribute nije validan.',
    'not_regex' => ':attribute ima nevalidan format.',
    'numeric' => ':attribute mora biti broj.',
    'present' => ':attribute mora postojati.',
    'regex' => ':attribute ima nevalidan format.',
    'required' => ':attribute polje je obavezno.',
    'required_if' => ':attribute polje je obavezno kada :other jednako :value.',
    'required_unless' => ':attribute polje je obavezno osim kada :other se nalazi u :values.',
    'required_with' => ':attribute polje je obavezno kada :values postoji.',
    'required_with_all' => ':attribute polje je obavezno kada sve vrijednosti :values postoje.',
    'required_without' => ':attribute polje je obavezno kada :values ne postoji.',
    'required_without_all' => ':attribute polje je obavezno kada ni jedna od :values ne postoje.',
    'same' => ':attribute i :other se moraju poklapati.',
    'size' => [
        'numeric' => ':attribute mora biti :size.',
        'file' => ':attribute mora biti :size kilobajta.',
        'string' => ':attribute mora biti :size karaktera.',
        'array' => ':attribute mora sadrzati :size elemenata.',
    ],
    'starts_with' => ':attribute mora pocinjati sa jednom od navedenih vrijednosti: :values',
    'string' => ':attribute mora biti string.',
    'timezone' => ':attribute mora biti validna vremenska zona.',
    'unique' => 'Vrijednost za :attribute nije dostupna.',
    'uploaded' => ':attribucte nije uspjesno prebacen.',
    'url' => ':attribute nevalidan format.',
    'uuid' => ':attribute mora biti validan UUID.',

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
