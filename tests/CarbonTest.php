<?php
class CarbonTest extends TestCase {
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_if_Carbon_parse_is_ok()
    {
        $this->assertEquals('10 seconds from now', \Carbon\Carbon::now()->addSeconds(10)->diffForHumans());
    }
}