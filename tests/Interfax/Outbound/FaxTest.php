<?php
/**
 * Interfax
 *
 * (C) InterFAX, 2016
 *
 * @package interfax/interfax
 * @author Interfax <dev@interfax.net>
 * @author Mike Smith <mike.smith@camc-ltd.co.uk>
 * @copyright Copyright (c) 2016, InterFAX
 * @license MIT
 */

namespace Interfax\Outbound;

class FaxTest extends \PHPUnit_Framework_TestCase
{

    public function test_successful_construction()
    {
        $client = $this->getMockBuilder('Interfax\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $fax = new Fax($client, 854759652);

        $this->assertInstanceOf('Interfax\Outbound\Fax', $fax);
    }

    public function test_can_reload_the_status_of_the_fax()
    {
        $client = $this->getMockBuilder('Interfax\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $reload_response = ['id' => 854759652,'uri' => 'https://rest.interfax.net/outbound/faxes/279415116','status' => 0];

        $client->expects($this->once())
            ->method('get')
            ->with('/outbound/faxes/854759652')
            ->will($this->returnValue($reload_response));

        $fax = new Fax($client, 854759652);

        $this->assertNull($fax->getStatus(false));
        $this->assertEquals(0, $fax->getStatus());

    }
}