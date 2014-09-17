<?php

class PasswordController extends BaseController {

    public function remind()
    {
        return View::make('account.password-reset');
    }

    public function postRemind()
    {
        Password::remind(Input::only('email'), function($message)
        {
            $message->subject('Password Reminder');
        });
        return Redirect::to('/account')
                ->with('global', '<div class="alert alert-success" role="alert">An email with password reset has been sent.</div>');

    }

    public function getRemindToken($token)
    {
        return View::make('account.password-reset-token')->with('token', $token);
    }

    public function postUpdatePwdWithToken()
    {
        $validator = Validator::make(Input::all(), array(
            'email' => 'required|email',
            'password' => User::$rules['password'],
            'password_confirmation' => User::$rules['password_confirmation'],
        ));
        if ( $validator->fails() ) {
            return Redirect::back()
            ->withErrors($validator);
        }
        else {
            $credentials = Input::only(
              'email', 'password', 'password_confirmation', 'token'
            );

            $response = Password::reset($credentials, function($user, $password)
            {
                $user->password = Hash::make($password);

                $user->save();
            });

            switch ($response)
            {
                case Password::INVALID_PASSWORD:
                    return Redirect::back()->with('global', '<div class="alert alert-danger" role="alert">' . Lang::get($response)) . '</div>';
                case Password::INVALID_TOKEN:
                    return Redirect::back()->with('global', '<div class="alert alert-danger" role="alert">' . Lang::get($response)) . '</div>';
                case Password::INVALID_USER:
                    return Redirect::back()->with('global', '<div class="alert alert-danger" role="alert">' . Lang::get($response)) . '</div>';

                case Password::PASSWORD_RESET:
                    return Redirect::to('/account/login')
                        ->with('global', '<div class="alert alert-success" role="alert">Your password has been reset</div>');
            }
        }

    }
}

?>