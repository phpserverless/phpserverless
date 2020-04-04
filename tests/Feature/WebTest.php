<?php

namespace Tests\Feature;

include_once dirname(__DIR__) . '/BaseTest.php';

class WebTest extends \Tests\BaseTest
{

    /**
     * Test index page shows the website
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get('/');
        $this->assertStringStartsWith('<!DOCTYPE html>', $response);
        $this->assertStringEndsWith('</html>', $response);
        $this->assertStringContainsString('<title>Home', $response);
    }

    /**
     * Test auth/passwordless
     * @return void
     */
    public function testAuthPasswordlessPage()
    {
        $response = $this->get('/auth/passwordless');
        $this->assertStringStartsWith('<!DOCTYPE html>', $response);
        $this->assertStringEndsWith('</html>', $response);
        $this->assertStringContainsString('<title>Login', $response);
        $this->assertStringContainsString('var once = $$.getUrlParam("once")', $response);
        $this->assertStringContainsString('if (once == null) {', $response);
        $this->assertStringContainsString('$$.ws("auth/passwordless"', $response);
    }

    /**
     * Test auth/passwordless
     * @return void
     */
    public function testAuthRegisterPage()
    {
        $response = $this->get('/auth/register');
        $this->assertStringStartsWith('<!DOCTYPE html>', $response);
        $this->assertStringEndsWith('</html>', $response);
        $this->assertStringContainsString('<title>Register', $response);
        $this->assertStringContainsString('$$.getUser() === null', $response);
        $this->assertStringContainsString('$$.getToken() === null', $response);
        $this->assertStringContainsString('$$.getUser().Status !== "Pending"', $response);
    }
}