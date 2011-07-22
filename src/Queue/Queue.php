<?php

namespace PEIP_Redis\Queue;

/*
 * This file is part of the PEIP_Redis package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Queue
 * Basic implementation of a Queue using a redis list
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP_Redis
 */

class Queue
    implements \PEIP\INF\Queue\Queue {

    protected 
        $client,
        $key,
        $timeout;

    public function __construct(\Predis\Client $client, $key, $timeout = 1){
        $this->client = $client;
        $this->key = $key;
        $this->timeout = $timeout;
    }

    public function enqueue($value){
        $this->client->rpush($this->key, $value);
    }

    public function dequeue(){
        $res = $this->client->blpop($this->key, $this->timeout);
        return $res[1];
    }




}
