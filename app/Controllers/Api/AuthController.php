<?php

namespace App\Controllers\Api;

class AuthController extends BaseController
{

    function anyIndex()
    {
        return $this->success('Api is working', ['time' => date('Y-m-d H:i:s')]);
    }

    function anyPasswordless()
    {
        $once = trim(req('once', ''));

        if ($once == '') {
            return $this->error('Once not specified');
        }

        // DEBUG: $email = 'lesichkovm@gmail.com';

        $url = 'https://authknight.com/who?once=' . urlencode($once);
        $who = json_decode(file_get_contents($url), true);

        if (
            \App\Helpers\App::environment() == "testing"
            or
            \App\Helpers\App::environment() == "local"
        ) {
            if ($once == "TESTKEY0768845593") {
                $who['data']['email'] = 'lesichkovm@gmail.com';
            }
        }
        // var_dump($who);

        $email = $who['data']['email'] ?? '';

        if ($email == '') {
            return $this->error('Passwordless auth expired');
        }

        $user = \App\Plugins\PersonPlugin::findPersonByEmail($email);

        if (is_null($user)) {
            $user = \App\Plugins\PersonPlugin::createPerson(array(
                'FirstName' => $email,
                'LastName' => '',
                'Email' => $email,
                'Status' => \App\Plugins\PersonPlugin::STATUS_PENDING,
            ));
        }

        if (is_null($user)) {
            return $this->error('Your account failed to be created. Please try again later');
        }

        return $this->success('Details verified successfuly', array('user' => $user, 'token' => $this->userTokenCreate($user)));
    }

    function anyRegister()
    {
        $verifyOrAuthRequiredResponse = $this->verifyUserRequest();
        if ($verifyOrAuthRequiredResponse !== true) {
            return $verifyOrAuthRequiredResponse;
        }

        $firstName = trim(req('FirstName', ''));
        $lastName = trim(req('LastName', ''));

        if ($firstName == '') {
            return $this->error('First name is required field');
        }
        if ($lastName == '') {
            return $this->error('Last name is required field');
        }
        $person = \App\Plugins\PersonPlugin::findPersonById($this->userId);

        if ($person == null) {
            return $this->error('Person with this e-mail not found');
        }

        $isUpdated = \App\Plugins\PersonPlugin::updatePersonById($this->userId, [
            'FirstName' => $firstName,
            'LastName' => $lastName,
            'Status' => \App\Plugins\PersonPlugin::STATUS_ACTIVE,
        ]);

        if ($isUpdated == true) {
            $person = \App\Plugins\PersonPlugin::findPersonById($this->userId);
            return $this->success("Registration was successful", ['user' => $person]);
        }

        return $this->error('Registration failed');
    }
}