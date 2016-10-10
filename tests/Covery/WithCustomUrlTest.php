<?php

class WithCustomUrlTest extends \PHPUnit_Framework_TestCase
{
    public function testWithCustomUrl()
    {
        $mock = self::getMock('Covery\\Client\\TransportInterface');
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'http://localhost/api/ping';
        }));
        $custom = new \Covery\Client\Transport\WithCustomUrl('http://localhost/', $mock);
        $custom->send(new \Covery\Client\Requests\Ping());

        $mock = self::getMock('Covery\\Client\\TransportInterface');
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'https://test.local:8083/api/ping';
        }));
        $custom = new \Covery\Client\Transport\WithCustomUrl('https://test.local:8083', $mock);
        $custom->send(new \Covery\Client\Requests\Ping());
    }
}
