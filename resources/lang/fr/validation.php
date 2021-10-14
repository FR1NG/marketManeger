<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "Ce champ doit être accepté.",
    "active_url"       => "Ce champ n'est pas une URL valide.",
    "after"            => "Ce champ doit être une date postérieure au :date.",
    "alpha"            => "Ce champ doit seulement contenir des lettres.",
    "alpha_dash"       => "Ce champ doit seulement contenir des lettres, des chiffres et des tirets.",
    "alpha_num"        => "Ce champ doit seulement contenir des chiffres et des lettres.",
    "before"           => "Ce champ doit être une date antérieure au :date.",
    "between"          => array(
        "numeric" => "La valeur de :attribute doit être comprise entre :min et :max.",
        "file"    => "Le fichier :attribute doit avoir une taille entre :min et :max kilobytes.",
        "string"  => "Le texte :attribute doit avoir entre :min et :max caractères.",
    ),
    "confirmed"        => "Le champ de confirmation :attribute ne correspond pas.",
    "date"             => "Ce champ n'est pas une date valide.",
    "date_format"      => "Ce champ ne correspond pas au format :format.",
    "different"        => "Les champs :attribute et :other doivent être différents.",
    "digits"           => "Ce champ doit avoir :digits chiffres.",
    "digits_between"   => "Ce champ doit avoir entre :min and :max chiffres.",
    "email"            => "Le format du champ :attribute est invalide.",
    "exists"           => "Ce champ sélectionné est invalide.",
    "image"            => "Ce champ doit être une image.",
    "in"               => "Ce champ est invalide.",
    "integer"          => "Ce champ doit être un entier.",
    "ip"               => "Ce champ doit être une adresse IP valide.",
    "max"              => array(
        "numeric" => "La valeur de :attribute ne peut être supérieure à :max.",
        "file"    => "Le fichier :attribute ne peut être plus gros que :max kilobytes.",
        "string"  => "Le texte de :attribute ne peut contenir plus de :max caractères.",
    ),
    "mimes"            => "Ce champ doit être un fichier de type : :values.",
    "min"              => array(
        "numeric" => "La valeur de :attribute doit être inférieure à :min.",
        "file"    => "Le fichier :attribute doit être plus que gros que :min kilobytes.",
        "string"  => "Le texte :attribute doit contenir au moins :min caractères.",
    ),
    "not_in"           => "Ce champ sélectionné n'est pas valide.",
    "numeric"          => "Ce champ doit contenir un nombre.",
    "regex"            => "Le format du champ :attribute est invalide.",
    "required"         => "Ce champ est obligatoire.",
    "required_if"      => "Ce champ est obligatoire quand la valeur de :other est :value.",
    "required_with"    => "Ce champ est obligatoire quand :values est présent.",
    "required_without" => "Ce champ est obligatoire quand :values n'est pas présent.",
    "same"             => "Les champs :attribute et :other doivent être identiques.",
    "size"             => array(
        "numeric" => "La taille de la valeur de :attribute doit être :size.",
        "file"    => "La taille du fichier de :attribute doit être de :size kilobytes.",
        "string"  => "Le texte de :attribute doit contenir :size caractères.",
    ),
    "unique"           => "La valeur du champ :attribute est déjà utilisée.",
    "url"              => "Le format de l'URL de :attribute n'est pas valide.",

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

);
