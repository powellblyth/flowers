<?php

namespace App\Http\Livewire;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class NewMemberForm extends Component
{
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $email = null;
    public ?string $address_1 = null;
    public ?string $address_2 = null;
    public ?string $address_town = null;
    public ?string $postcode = null;
    public ?string $telephone = null;
    public ?bool $can_retain_data = null;
    public ?bool $can_email = null;
    public ?bool $can_phone = null;
    public ?bool $can_sms = null;
    public ?bool $can_post = null;


    public ?bool $succeeded = false;

    protected function rules(): array
    {
        return (new UserRequest())->rules();
    }

    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
    ];

    protected $validationAttributes = [
        'email' => 'email address'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    //    public function render()
//    {
//        return view('livewire.new-member-form');
//    }

//    public function updated($propertyName)
//    {
//        $this->validateOnly($propertyName);
//    }
    public function submit()
    {
        $validatedData = $this->validate();
        $optIns = ['retain_data', 'post', 'sms', 'email'];
        $optInRequest = [];
//        var_dump($validatedData);
        foreach ($optIns as $optin) {
            if ($this->{'can_' . $optin} == '1') {
                $optInRequest['can_' . $optin] = 1;
                $optInRequest[$optin . '_opt_in'] = Carbon::now();
            } else {
                $optInRequest['can_' . $optin] = 0;
                $optInRequest[$optin . '_opt_out'] = Carbon::now();
            }
        }
        if (User::create(
            array_merge($validatedData, $optInRequest)
        )) {
            // reset this object
            $this->succeeded = true;
            $this->first_name = null;
            $this->last_name = null;
            $this->telephone = null;
            $this->address_1 = null;
            $this->address_2 = null;
            $this->address_town = null;
            $this->postcode = null;
            $this->can_retain_data = null;
            $this->can_email = null;
            $this->can_post = null;
            $this->can_phone = null;
            $this->can_sms = null;
            // success
            return redirect(request()->header('Referer'));

        } else {
            // mot success
        }
    }
}
