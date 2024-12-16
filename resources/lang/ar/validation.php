<?php
return [
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
    'accepted' => 'يجب قبول :attribute',
    'accepted_if' => ':attribute مقبول في حال ما إذا كان :other يساوي :value.',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'current_password' => 'كلمة المرور غير صحيحة',
    'date' => ':attribute ليس تاريخًا صحيحًا',
    'date_equals' => 'لا يساوي :attribute مع :date.',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'declined' => 'يجب رفض :attribute',
    'declined_if' => ':attribute مرفوض في حال ما إذا كان :other يساوي :value.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'ends_with' => 'الـ :attribute يجب ان ينتهي بأحد القيم التالية :value.',
    'enum' => ':attribute غير صحيح',
    'exists' => ':attribute مطلوبه',
    'file' => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled' => ':attribute إجباري',
    'gt' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اكبر من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من :value.',
        'string' => 'الـ :attribute يجب ان يكون اكبر من :value حروفٍ/حرفًا.',
    ],
    'gte' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي :value عناصر/عنصر او اكثر.',
        'file' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value.',
        'string' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value حروفٍ/حرفًا.',
    ],
    'image' => 'يجب أن يكون :attribute صورةً',
    'in' => ':attribute مطلوبه',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP ذا بُنية صحيحة',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 ذا بنية صحيحة.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 ذا بنية صحيحة.',
    'json' => 'يجب أن يكون :attribute نصا من نوع JSON.',
    'lt' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اقل من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اقل من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من :value.',
        'string' => 'الـ :attribute يجب ان يكون اقل من :value حروفٍ/حرفًا.',
    ],
    'lte' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value.',
        'string' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value حروفٍ/حرفًا.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC ذا بنية صحيحة.',
    'max' => [
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
        'string' => 'يجب أن لا يتجاوز طول نص :attribute :max حروفٍ/حرفًا',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
        'string' => 'يجب أن يكون طول نص :attribute على الأقل :min حروفٍ/حرفًا',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => ':attribute مطلوبه',
    'not_regex' => ':attribute نوعه مطلوبه',
    'numeric' => 'يجب على :attribute أن يكون رقمًا',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب تقديم :attribute',
    'prohibited' => ':attribute محظور',
    'prohibited_if' => ':attribute محظور في حال ما إذا كان :other يساوي :value.',
    'prohibited_unless' => ':attribute محظور في حال ما لم يكون :other يساوي :value.',
    'prohibits' => ':attribute يحظر :other من اي يكون موجود',
    'regex' => 'صيغة :attribute .غير صحيحة',
    'required' => ':attribute مطلوب.',
    'required_array_keys' => ':attribute يجب ان يحتوي علي مدخلات للقيم التالية :values.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute إذا توفّر :values.',
    'required_with_all' => ':attribute إذا توفّر :values.',
    'required_without' => ':attribute إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
    ],
    'starts_with' => ':attribute يجب ان يبدأ بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',
    'uuid' => ':attribute يجب ان ايكون رقم UUID صحيح.',
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
        "g-recaptcha-response"=>"حقل التحقق",
        "how_to_know_us"=>"كيف علمت بنا",
        "password"=>"كلمه المرور",
        "devices_token"=>"توكن الجهاز",
        "job"=>"الوظيفه",
        "private_sector"=>"قطاع خاص",
        "public"=>"قطاع عام وحكومى",
        "company_name"=>"إسم الشركه",
        "company_address"=>"عنوان الشركه",
        "national_pdf"=>"صوره البطاقه",
        "full_name"=>"الإسم بالكامل",
        "username"=>"إسم المستخدم",
        "phone"=>"الهاتف",
        "email"=>"البريد اللإلكتروني",
        "first_name"=>"الإسم الأول",
        "last_name"=>"الإسم الأخير",
        "country"=>"الدوله",
        "city"=>"المدينة",
        "ifp_id"=>"الرقم الموحد للهيئة",
        "fra_code"=>"كود التأميني",
        "insurance_professional"=>"مهني تأمين",
        "registration_date"=>"تاريخ الإنضمام",
        "recording_type"=>"نوع التسجيل",
        "nationality_type"=>"الجنسية",
        "egyptian"=>"مصري",
        "national_number"=>"الرقم القومي",
        "passport_number"=>"جواز السفر"
    ],
];
