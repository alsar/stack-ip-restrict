<?php
namespace Alsar\Stack;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class StackIpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ipProvider
     */
    public function testIpIsAllowed($ip)
    {
        $requestStub = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
                        ->disableOriginalConstructor()
                        ->getMock();

        $requestStub->expects($this->any())
                    ->method('getClientIp')
                    ->will($this->returnValue($ip));

        $responseStub = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
                             ->disableOriginalConstructor()
                             ->getMock();

        $kernelStub = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');

        $kernelStub->expects($this->any())
                    ->method('handle')
                    ->will($this->returnValue($responseStub));

        $allowedIps = [
            '49.93.171.173',
            '55.33.87.149',
            '205.1.4.93',
            '208.223.94.67',
            '254.147.22.74',
            '94.123.149.95'
        ];

        $stackIp = new IpRestrict($kernelStub, $allowedIps);

        $response = $stackIp->handle($requestStub);

        $this->assertEquals($response, $responseStub);
    }

    /**
     * @dataProvider ipProvider
     */
    public function testIpIsNotAllowed($ip)
    {
        $requestStub = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
                            ->disableOriginalConstructor()
                            ->getMock();

        $requestStub->expects($this->any())
                    ->method('getClientIp')
                    ->will($this->returnValue($ip));

        $responseStub = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
                             ->disableOriginalConstructor()
                             ->getMock();

        $kernelStub = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');

        $kernelStub->expects($this->any())
                   ->method('handle')
                   ->will($this->returnValue($responseStub));

        $allowedIps = [
            '15.203.46.81',
            '230.23.252.71',
            '51.251.1.176',
            '57.157.210.15',
            '71.97.235.13',
            '178.66.122.48'
        ];
        $stackIp = new IpRestrict($kernelStub, $allowedIps);

        $response = $stackIp->handle($requestStub);

        $this->assertEquals(sprintf('IP %s is not allowed.', $ip), $response->getContent());
    }

    public function ipProvider()
    {
        return [
            ['55.33.87.149'],
            ['205.1.4.93'],
            ['208.223.94.67'],
            ['94.123.149.95']
        ];
    }
}
