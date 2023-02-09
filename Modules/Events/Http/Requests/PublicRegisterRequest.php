<?php

namespace Modules\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Events\Entities\Event;

class PublicRegisterRequest extends FormRequest
{
    protected $event = null;
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
        $slug = $this->route('slug');

        if(!isset($this->event)){
            $this->event = Event::where('short_slug', '=', $slug)->firstOrFail();
        }
        $event = $this->event;
        return $event->getRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $slug = $this->route('slug');

        if(!isset($this->event)){
            $this->event = Event::where('short_slug', '=', $slug)->firstOrFail();
        }
        $event = $this->event;

        $messages = [
            'fullname.required' => __('Fullname is required'),
            'fullname.max' => __('Fullname is 255 max length'),
            'email.required' => __('Email is required'),
            'email.max' => __('Email is 255 max length'),
            'email.email' => __('Email is invalid'),
            'ticket.required' => __('Ticket is required'),
        ];

        if(count($event->info_items) > 0){
            $info_cnt = count($event->info_items['name']);
            for($i = 0; $i < $info_cnt; $i++){
                $input_name =  'info_item_' . $i;
                $messages[$input_name . '.required'] = __('This field is required');
                $messages[$input_name . '.in'] = __('This field is invalid');
            }            
        }

        return $messages;
    }
}
