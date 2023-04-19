<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $storageOptions  = ['0GB', '250GB', '500GB', '1TB', '2TB', '3TB', '4TB', '8TB', '12TB', '24TB', '48TB', '72TB'];
        $ramOptions = [2, 4, 8, 12, 16, 24, 32, 48, 64, 96];
        $harddiskTypeOptions = ['', 'SAS', 'SATA', 'SSD'];
        $locationOptions = ['', 'AmsterdamAMS-01', 'DallasDAL-10', 'FrankfurtFRA-10', 'Hong KongHKG-10', 'San FranciscoSFO-12', 'SingaporeSIN-11', 'Washington D.C.WDC-01'];

        return [
            'ram.*' => 'in:' . join(',', $ramOptions),
            'storageFrom' => 'in:' . join(',', $storageOptions),
            'storageTo' => 'in:' . join(',', $storageOptions),
            'harddiskType' => 'in:' . join(',', $harddiskTypeOptions),
            'location' => 'in:' . join(',', $locationOptions),
        ];
    }
}
