<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DesignRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->method() == "POST") {
            return [
                'name' => ['unique:designs', 'required', 'string', 'max:255', 'regex:/^[0-9 a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼẾỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệếỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳýỵỷỹ,;.]+$/'],
                'progress' => ['required', 'string', 'max:255'],
                'staff_id' => ['required', 'string', 'max:255'],
                'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg'],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255', 'regex:/^[0-9 a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼẾỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệếỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳýỵỷỹ,;.]+$/'],
                'progress' => ['required', 'string', 'max:255'],
                'staff_id' => ['required', 'string', 'max:255'],
                'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg'],
            ];
        }
    }

    public function attributes()
    {
        return [
            'name' => 'Tên mẫu thiết kế',
            'image' => 'ảnh',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Không cho phép nhập ký tự đặc biệt',
        ];
    }
}
