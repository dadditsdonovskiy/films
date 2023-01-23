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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute must be no greater than :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => ':attribute must be no less than :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => ':attribute must be either "true" or "false"',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The format of :attribute is invalid.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute is not a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => ':attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => ':attribute must be no greater than :value.',
        'file' => 'The file :attribute is too small. Its size cannot be smaller than :value.',
        'string' => ':attribute should contain at most :value character(s).',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute must be no greater or equal than :value.',
        'file' => 'The file :attribute is too small. Its size cannot be smaller than :value.',
        'string' => ':attribute should contain at most or equal :value character(s).',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The file :attribute is not an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute must be an integer.',
    'ip' => ':attribute must be a valid IP address.',
    'ipv4' => ':attribute must not be an IPv4 address.',
    'ipv6' => ':attribute must not be an IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => ':attribute must be no less than :value.',
        'file' => 'The file :attribute is too big. Its size cannot exceed :value kilobytes.',
        'string' => ':attribute should contain at least :value character(s).',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute must be no less or equal than :value.',
        'file' => 'The file :attribute is too big. Its size cannot exceed :value kilobytes.',
        'string' => ':attribute should contain at least or equal :value character(s).',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute must be no greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => ':attribute should contain at most :max character(s).',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'Only files with these MIME types are allowed: :values.',
    'min' => [
        'numeric' => ':attribute must be no less than :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute  should contain at least :min  character(s).',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => ':attribute is invalid.',
    'required' => ':attribute cannot be blank.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute has already been taken.',
    'uploaded' => 'File upload failed.',
    'url' => ':attribute is not a valid link.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'password' => ':attribute should contain at least 10 symbols, one lower case, one upper case and one num.',
    'credentials_invalid' => 'Invalid email or password',
    'phone_number_mask' => ':attribute must be in the format (XXX) XXX-XXXX',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'backend' => [
            'access' => [
                'permissions' => [
                    'associated_roles' => 'Associated Roles',
                    'dependencies' => 'Dependencies',
                    'display_name' => 'Display Name',
                    'group' => 'Group',
                    'group_sort' => 'Group Sort',

                    'groups' => [
                        'name' => 'Group Name',
                    ],

                    'name' => 'Name',
                    'first_name' => 'First Name',
                    'last_name' => 'Last Name',
                    'system' => 'System',
                ],

                'roles' => [
                    'associated_permissions' => 'Associated Permissions',
                    'name' => 'Name',
                    'sort' => 'Sort',
                ],

                'users' => [
                    'active' => 'Active',
                    'associated_roles' => 'Associated Roles',
                    'confirmed' => 'Confirmed',
                    'email' => 'E-mail Address',
                    'name' => 'Name',
                    'last_name' => 'Last Name',
                    'first_name' => 'First Name',
                    'other_permissions' => 'Other Permissions',
                    'password' => 'Password',
                    'password_confirmation' => 'Password Confirmation',
                    'send_confirmation_email' => 'Send Confirmation E-mail',
                    'timezone' => 'Timezone',
                    'language' => 'Language',
                ],
            ],
        ],

        'frontend' => [
            'avatar' => 'Avatar Location',
            'email' => 'E-mail Address',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'name' => 'Full Name',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
            'phone' => 'Phone',
            'message' => 'Message',
            'new_password' => 'New Password',
            'new_password_confirmation' => 'New Password Confirmation',
            'old_password' => 'Old Password',
            'timezone' => 'Timezone',
            'language' => 'Language',
        ],
    ],
];
