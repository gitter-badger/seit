<?php
class BasicTest extends TestCase {
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRedirectIfNotLoggedIn()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
