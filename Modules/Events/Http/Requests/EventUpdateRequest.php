<?php

namespace Modules\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => 'required|max:255',
            'tagline'=> 'nullable',
            'quantity' => 'required|integer|min:-1',
            'type' => 'required|in:ONLINE,OFFLINE',
            'address' => 'required_if:type,OFFLINE|max:255',
            'register_end_date' => 'required|date_format:Y-m-d H:i:s',
            'start_date' => 'required|date_format:Y-m-d H:i:s|before:end_date',
            'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            'description' => 'required',
            'email_content' => 'nullable',
            'email_sender_name' => 'required|max:255',
            'email_sender_email' => 'required|email',
            'email_subject' => 'required|max:255',
            'second_email_subject' => 'nullable|max:255',
            'second_email_content' => 'nullable',
            'second_email_attach' => 'nullable',
            'second_email_status' => 'nullable',
            'noti_register_success'=> 'required|max:255',
            'short_slug' => 'required|unique:Modules\Events\Entities\Event,short_slug,'.$id,
            'info_items' => [
                'nullable',
                function($attribute, $value, $fail){
                    $fail_message = 'Informations is invalid';
                    if(is_array($value)){
                        if(
                            isset($value['name']) && is_array($value['name'])
                            && isset($value['data_type']) && is_array($value['data_type'])
                            && isset($value['is_required']) && is_array($value['is_required'])
                            && isset($value['values']) && is_array($value['values'])
                            && count($value['name']) == count($value['data_type']) && count($value['data_type']) == count($value['is_required']) && count($value['is_required']) == count($value['values'])
                        ){
                            // pass
                        }else{
                            $fail($fail_message);
                        }
                    }else{
                        $fail($fail_message);
                    }
                },
            ],
            'ticket_currency'=> 'required',
            'ticket_items' => [
                'nullable',
                function($attribute, $value, $fail){
                    $fail_message = 'Tickets is invalid';
                    if(is_array($value)){
                        if(
                            isset($value['name']) && is_array($value['name'])
                            && isset($value['price']) && is_array($value['price'])
                            && isset($value['description']) && is_array($value['description'])
                            && count($value['name']) == count($value['price']) && count($value['price']) == count($value['description'])
                        ){
                            // pass
                        }else{
                            $fail($fail_message);
                        }
                    }else{
                        $fail($fail_message);
                    }
                },
            ],
            'background' => 'nullable|image',
            'theme' => 'nullable|max:255',
            'theme_color' => 'nullable|max:255',
            'font_family' => 'nullable|max:255',
            'custom_header'  => 'nullable',
            'custom_footer'  => 'nullable',
            
            'favicon' => 'nullable',
            'custom_domain' => 'nullable',
            'seo_enable' => 'nullable',
            'seo_title' => 'nullable',
            'seo_description' => 'nullable',
            'seo_keywords' => 'nullable',
            'social_title' => 'nullable',
            'social_image' => 'nullable',
            'social_description' => 'nullable',
            'is_listing' => 'nullable|boolean',
            'is_recur' => 'nullable|boolean',
            'recur_repeat' => 'nullable',
            'recur_week' => 'nullable',
            'recur_end_date' => 'nullable|date_format:Y-m-d H:i:s',
            'upsells' => 'nullable',
            'terms_and_conditions' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('Name is required'),
            'name.max' => __('Name length is 255 max'),
            'category_id.required' => __('Category is required'),
            'category_id.integer' => __('Category is invalid'),
            'category_id.min' => __('Category is invalid'),
            'quantity.required' => __('Quantity is required'),
            'quantity.integer' => __('Quantity is invalid'),
            'quantity.min' => __('Quantity is invalid'),
            'type.required' => __('Type is required'),
            'type.in' => __('Type is invalid'),
            'address.required_if' => __('Address is required'),
            'address.max' => __('Address length is 255 max'),
            'register_end_date.required' => __('Register end date is required'),
            'register_end_date.date_format' => __('Register end date is invalid'),
            'finish_time.required' => __('Finish time is required'),
            'finish_time.date_format' => __('Finish time is invalid'),
            'description.required' => __('Description is required'),
            'short_slug.required' => __('Short slug is required'),
            'short_slug.unique' => __('Short slug is already existed'),
            'background.image' => __('Background must be image'),
        ];
    }
}
