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
        $this->assertStringStartsWith('<html', $response);
        $this->assertStringEndsWith('</html>', $response);
    }
}