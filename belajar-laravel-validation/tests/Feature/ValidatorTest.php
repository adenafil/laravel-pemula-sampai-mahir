<?php

namespace Tests\Feature;

use App\Rules\RegistrationRule;
use App\Rules\Uppercase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = [
            'username' => 'admin',
            'password' => '12345'
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);
        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testValidatorInvalid()
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidationException()
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try {
            $validator->validate();
            self::fail('ValidationException not thrown');
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorMultipleRules()
    {
        App::setLocale('id');

        $data = [
            'username' => 'admin',
            'password' => 'rasia'
        ];

        $rules = [
            'username' => 'required | email | max: 100',
            'password' => ['required', 'min: 6', 'max: 20']
        ];
        $validator = Validator::make($data, $rules);

        self::assertNotNull($validator);

        $message = $validator->getMessageBag();

        self::assertTrue($validator->fails());
        Log::error($message->toJson(JSON_PRETTY_PRINT));

    }

    public function testValidatorValidData()
    {
        $data = [
            'username' => 'admin@pzn.com',
            'password' => 'rahasia',
            'admin' => true,
            'others' => 'xxx'
        ];

        $rules = [
            'username' => 'required | email | max: 100',
            'password' => 'required | min : 6 | max : 20'
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try {
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorInlineMessage()
    {

        $data = [
            'username' => 'admin',
            'password' => 'rasia'
        ];

        $rules = [
            'username' => 'required | email | max: 100',
            'password' => ['required', 'min:6', 'max: 20']
        ];

        $messages = [
          'required' => ':attribute harus diisi',
          'email' => ':attribute harus berupa email',
          'min' => ':attribute harus :min karakter',
          'max' => ':attribute harus :max karakter',
        ];

        $validator = Validator::make($data, $rules, $messages);

        self::assertNotNull($validator);

        $message = $validator->getMessageBag();

        self::assertTrue($validator->fails());
        Log::error($message->toJson(JSON_PRETTY_PRINT));

    }

    public function testValidatorAdditionalValidation()
    {
        $data = [
            'username' => 'ade@pzn.com',
            'password' => 'ade@pzn.com'
        ];

        $rules = [
            'username' => 'required | email | max: 100',
            'password' => ['required', 'min: 6', 'max: 20']
        ];
        $validator = Validator::make($data, $rules);
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();

            if ($data['username'] == $data['password']) {
                $validator->errors()->add('password','password tidak boleh sama dengan username');
            }
        });

        self::assertNotNull($validator);

        $message = $validator->getMessageBag();

        self::assertTrue($validator->fails());
        Log::error($message->toJson(JSON_PRETTY_PRINT));

    }

    public function testValidatorCustomeRule()
    {
        $data = [
            'username' => 'ade@pzn.com',
            'password' => 'ade@pzn.com'
        ];

        $rules = [
            'username' => ['required', 'email', 'max: 100', new Uppercase()],
            'password' => ['required', 'min: 6', 'max: 20', new RegistrationRule()]
        ];
        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();

        Log::error($message->toJson(JSON_PRETTY_PRINT));

    }


}
