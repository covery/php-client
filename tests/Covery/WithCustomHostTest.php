<?php

namespace Tests\Covery;

use Covery\Client\Requests\Ping;
use Covery\Client\Transport\WithCustomHost;
use Covery\Client\TransportInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Http\Message\RequestInterface;

class WithCustomHostTest extends TestCase
{
    public function testWithCustomUrl()
    {
        /** @var TransportInterface|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = self::createMock(TransportInterface::class);
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(RequestInterface $req) {
            return strval($req->getUri()) == 'ftp://localhost/api/ping';
        }));
        $custom = new WithCustomHost($mock, 'localhost', 'ftp');
        $custom->send(new Ping());

        $mock = self::createMock(TransportInterface::class);
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(RequestInterface $req) {
            return strval($req->getUri()) == 'https://test.local:8083/api/ping';
        }));
        $custom = new WithCustomHost($mock, 'test.local:8083', 'https');
        $custom->send(new Ping());
    }
}
