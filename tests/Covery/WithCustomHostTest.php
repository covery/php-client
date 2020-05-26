<?php

class WithCustomHostTest extends \PHPUnit_Framework_TestCase
{
    public function testWithCustomUrl()
    {
        $mock = self::getMockBuilder('Covery\\Client\\TransportInterface')->getMock();
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'ftp://localhost/api/ping';
        }));
        $custom = new \Covery\Client\Transport\WithCustomHost($mock, 'localhost', 'ftp');
        $custom->send(new \Covery\Client\Requests\Ping());

        $mock = self::getMockBuilder('Covery\\Client\\TransportInterface')->getMock();
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'https://test.local:8083/api/ping';
        }));
        $custom = new \Covery\Client\Transport\WithCustomHost($mock, 'test.local:8083', 'https');
        $custom->send(new \Covery\Client\Requests\Ping());
    }
}
