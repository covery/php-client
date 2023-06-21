<?php

class WithCustomHostTest extends \PHPUnit_Framework_TestCase
{
    public function testWithCustomUrl()
    {
        $result = \Covery\Client\Envelopes\Builder::postBackEvent(1)->build();

        $mock = self::getMockBuilder('Covery\\Client\\TransportInterface')->getMock();
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'ftp://localhost/api/postback';
        }));
        $custom = new \Covery\Client\Transport\WithCustomHost($mock, 'localhost', 'ftp');
        $custom->send(new \Covery\Client\Requests\Postback($result));

        $mock = self::getMockBuilder('Covery\\Client\\TransportInterface')->getMock();
        $mock->expects(self::exactly(1))->method('send')->with(self::callback(function(\Psr\Http\Message\RequestInterface $req) {
            return strval($req->getUri()) == 'https://test.local:8083/api/postback';
        }));
        $custom = new \Covery\Client\Transport\WithCustomHost($mock, 'test.local:8083', 'https');
        $custom->send(new \Covery\Client\Requests\Postback($result));
    }
}
