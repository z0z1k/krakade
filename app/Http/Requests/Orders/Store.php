<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => 'required',
            'city' => 'required',
            'client_address' => 'required',
            'client_address_info' => 'required',
            'client_phone' => 'required',
            'approximate_ready_at' => 'required',
            'payment' => 'nullable|numeric|between:0,10000',
            'problem' => 'nullable|min:2',
        ];
    }

    public function messages()
    {
        return [
            'client_address' => 'Вкажіть вулицю та номер будинку',
            'client_address_info' => 'Вкажіть квартиру та/або додаткову інформацію',
            'client_phone' => 'Вкажіть номер телефону клієнта',
            'approximate_ready_at' => 'Вкажіть приблизний час готовності замовлення',
            'payment' => 'Вкажіть число',
            'problem' => 'Опишіть, будь ласка',
            'location' => 'Спробуйте ще раз ввести адресу'
        ];
    }
}