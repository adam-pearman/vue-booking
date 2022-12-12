<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class PaymentIntentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reservations' => 'required|array|min:1',
            'reservations.*.booking_id' => 'required|exists:bookings,id',
            'reservations.*.from' => 'required|date|after_or_equal:today',
            'reservations.*.to' => 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.street' => 'required|min:5',
            'customer.city' => 'required|min:3',
            'customer.country' => 'required|min:2',
            'customer.county' => 'required|min:5',
            'customer.postcode' => 'required|min:5|max:7',        ];
    }

    public function attributes()
    {
        return [
            'customer.first_name' => 'first name',
            'customer.last_name' => 'last name',
            'customer.email' => 'email',
            'customer.street' => 'street',
            'customer.city' => 'city',
            'customer.country' => 'country',
            'customer.county' => 'county',
            'customer.postcode' => 'postcode',
        ];
    }
}
