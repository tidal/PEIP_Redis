<?php
require_once __DIR__.'/../../src/Queue/Queue.php';
require_once __DIR__.'/../bootstrap.php';

class RedisCommandTestSuite extends PHPUnit_Framework_TestCase {
    public $redis;

    protected function setUp() {
        $this->redis = RC::getConnection();
        $this->redis->flushdb();
    }

    public function testEnqueue(){
        $key = 'bar';
        $value = 'foo';
        $queue = new PEIP_Redis\Queue\Queue($this->redis, $key);

        $queue->enqueue($value);

        $this->assertEquals($value, $queue->dequeue());
    }

    public function testEnqueueError(){
        $key = 'bar';
        $value = 'foo';
        $queue = new PEIP_Redis\Queue\Queue($this->redis, $key);

        $this->assertNotEquals($value, $queue->dequeue());
    }

    public function testEnqueueTimeout(){
        $key = 'bar';
        $value = 'foo';
        $timeout = 1;
        $time1 = microtime(1);
        $queue = new PEIP_Redis\Queue\Queue($this->redis, $key);
        $queue->dequeue();
        $this->assertGreaterThanOrEqual($time1 + $timeout, microtime(1));
    }



}

