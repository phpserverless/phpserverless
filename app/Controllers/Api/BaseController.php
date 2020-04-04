<?php

namespace App\Controllers\Api;

class BaseController
{

    public $userId = null;

    public function verifyUserRequest()
    {
        $token = req('Token');
        $userId = \App\Helpers\App::userIdFromToken($token);
        if (is_null($userId)) {
            return $this->authenticationFailed('Your session has expired');
        }
        $this->userId = $userId;
        return true;
    }

    function userTokenCreate($person)
    {
        $token = \Sinevia\StringUtils::random(20);
        \App\Plugins\CachePlugin::set($token, ['PersonId' => $person['Id']]);
        return $token;
    }

    protected function respond($jsonResponse)
    {
        $callback = (isset($_REQUEST['callback']) == false) ? '' : trim(strip_tags($_REQUEST['callback']));
        // JSONP
        if ($callback !== '') {
            return $callback . "(" . $jsonResponse . ")";
        } else {
            return $jsonResponse;
        }
    }

    /**
     * @param mixed $msg
     * @return string
     */
    protected function error($message = null)
    {
        $response = new \Sinevia\ApiResponse;
        $response->setStatus(\Sinevia\ApiResponse::ERROR);
        if ($message != null) {
            $response->setMessage($message);
        }
        return $this->respond($response->toJson());
    }

    /**
     * @param mixed $msg
     * @return string
     */
    protected function success($message, $data = null)
    {
        $response = new \Sinevia\ApiResponse;
        $response->setStatus(\Sinevia\ApiResponse::SUCCESS);
        $response->setMessage($message);
        if ($data != null) {
            $response->setData($data);
        }
        return $this->respond($response->toJson());
    }

    /**
     * @param mixed $msg
     * @return string
     */
    protected function authenticationFailed($statusMessage = 'Authentication failed', $data = null)
    {
        $response = new \Sinevia\ApiResponse;
        $response->setStatus(\Sinevia\ApiResponse::AUTHENTICATION_FAILED);
        if ($statusMessage != null) {
            $response->setMessage($statusMessage);
        }
        if ($data != null) {
            $response->setData($data);
        }
        return $this->respond($response->toJson());
    }

    public function transformUserToAppUser($user)
    {
        return [
            'FirstName' => $user['FirstName'],
            'LastName' => $user['LastName'],
            'Country' => $user['Country'],
            'Email' => $user['Email'],
        ];
    }
}