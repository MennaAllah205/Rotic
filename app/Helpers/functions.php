<?php

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

if (! function_exists('getLocaleFromRequest')) {
    function getLocaleFromRequest(): string
    {
        $locale = request()->header('Locale', 'ar');
        return in_array($locale, ['en', 'ar']) ? $locale : 'ar';
    }
}
if (! function_exists('getPerPage')) {
    function getPerPage(Request $request, int $defaultPerPage = 25, int $maxPerPage = 200): int
    {
        $perPage = $request->get('per_page', $defaultPerPage);

        if (! is_numeric($perPage)) {
            $perPage = $defaultPerPage;
        }
        return (int) min($perPage, $maxPerPage);
    }
}

if (! function_exists('backWithSuccess')) {
    function backWithSuccess($msg = null, $data = null)
    {
        $locale = getLocaleFromRequest();

        $defaultMessages = [
            'en' => 'Operation completed successfully',
            'ar' => 'تم الأمر بنجاح',
        ];

        $msg = $msg ?? $defaultMessages[$locale];

        $response = ['message' => $msg];

        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
}

if (! function_exists('backWithWarning')) {
    function backWithWarning($ar_message = "", $en_message = "", $code = 422)
    {
        $locale = getLocaleFromRequest();
        $msg    = $locale == 'en' ? $en_message : $ar_message;
        return response()->json(['message' => $msg], $code);
    }
}

if (! function_exists('backWithError')) {
  function backWithError($e = null, $status = 500)
{
    $locale = getLocaleFromRequest();

    $defaultErrorMessages = [
        'en' => 'An error occurred: :msg',
        'ar' => 'حدث خطأ: :msg',
    ];

    if ($e instanceof ValidationException) {
        return response()->json(['message' => $e->errors()], 422);
    }

    // 👇 هنا التعديل
    $messageText = is_string($e)
        ? $e
        : ($e?->getMessage() ?? '');

    $template = $defaultErrorMessages[$locale];
    $message  = str_replace(':msg', $messageText, $template);

    return response()->json(['message' => $message], $status);
}
}

if (! function_exists('getCustomValidationMessages')) {
    function getCustomValidationMessages(): array
    {
        $locale = getLocaleFromRequest();

        $messages = [
            'en' => [
                'required'    => 'The :attribute field is required.',
                'starts_with' => 'The :attribute must start with one of the allowed values.',
                'string'      => 'The :attribute must be a string.',
                'max'         => 'The :attribute may not be greater than :max.',
                'min'         => 'The :attribute must be at least :min.',
                'unique'      => 'The :attribute has already been taken.',
                'email'       => 'The :attribute must be a valid email address.',
                'integer'     => 'The :attribute must be an integer.',
                'array'       => 'The :attribute must be an array.',
                'exists'      => 'The selected :attribute is invalid.',
                'date'        => 'The :attribute is not a valid date.',
                'boolean'     => 'The :attribute field must be true or false.',
                'confirmed'   => 'The :attribute confirmation does not match.',
                'url'         => 'The :attribute must be a valid URL.',
                'uuid'        => 'The :attribute must be a valid UUID.',
                'regex'       => 'The :attribute format is invalid.',
                'mimes'       => 'The :attribute must be a file of type: :values.',
                'image'       => 'The :attribute must be an image.',
                'size'        => 'The :attribute must be :size.',
                'in'          => 'The :attribute must be one of the following: :values.',
                'gt'          => 'The :attribute must be greater than :value.',
                'lt'          => 'The :attribute must be less than :value.',
                'between'     => 'The :attribute must be between :min and :max.',
                'nullable'    => 'The :attribute field may be null.',
                'same'        => 'The :attribute and :other must match.',
                'distinct'    => 'The :attribute field has a duplicate value.',
            ],

            'ar' => [
                'required'    => 'حقل :attribute مطلوب.',
                'starts_with' => 'حقل :attribute يجب أن يبدأ بأحد القيم المسموح بها.',
                'string'      => 'حقل :attribute يجب أن يكون نصًا.',
                'max'         => 'حقل :attribute يجب ألا يتجاوز :max.',
                'min'         => 'حقل :attribute يجب أن يكون على الأقل :min.',
                'unique'      => 'حقل :attribute مسجل بالفعل.',
                'email'       => 'حقل :attribute يجب أن يكون بريدًا إلكترونيًا صالحًا.',
                'integer'     => 'حقل :attribute يجب أن يكون عددًا صحيحًا.',
                'array'       => 'حقل :attribute يجب أن يكون مصفوفة.',
                'exists'      => 'حقل :attribute لا يوجد في قاعدة البيانات.',
                'date'        => 'حقل :attribute يجب أن يكون تاريخًا صالحًا.',
                'boolean'     => 'حقل :attribute يجب أن يكون صحيحًا أو خطأ.',
                'confirmed'   => 'حقل :attribute لا يتطابق مع تأكيد :attribute.',
                'url'         => 'حقل :attribute يجب أن يكون رابطًا صالحًا.',
                'uuid'        => 'حقل :attribute يجب أن يكون UUID صالحًا.',
                'regex'       => 'حقل :attribute لا يتطابق مع النمط المحدد.',
                'mimes'       => 'حقل :attribute يجب أن يكون من نوع ملف :values.',
                'image'       => 'حقل :attribute يجب أن يكون صورة.',
                'size'        => 'حقل :attribute يجب أن يكون بحجم :size.',
                'in'          => 'حقل :attribute يجب أن يكون أحد القيم التالية: :values.',
                'gt'          => 'حقل :attribute يجب أن يكون أكبر من :value.',
                'lt'          => 'حقل :attribute يجب أن يكون أصغر من :value.',
                'between'     => 'حقل :attribute يجب أن يكون بين :min و :max.',
                'nullable'    => 'حقل :attribute يمكن أن يكون فارغًا.',
                'same'        => 'حقل :attribute يجب أن يتطابق مع :other.',
                'distinct'    => 'حقل :attribute يحتوي على قيم مكررة.',
            ],
        ];

        return $messages[$locale];
    }
}
