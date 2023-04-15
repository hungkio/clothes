<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProduceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['unique:produces','required', 'string', 'max:255', 'regex:/^[0-9 a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼẾỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệếỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳýỵỷỹ,;.]+$/'],
            'quantity' => ['required', 'numeric'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên nguyên liệu',
            'quantity' => 'Số lượng',
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
