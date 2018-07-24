<?php

namespace tests\TLH\ContactBundle\Services;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use TLH\ContactBundle\Services\Messager;

class MessagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group Services
     */
    public function getParameter()
    {
        $parameters = [
            'parameter1' => [
                'value1' => 'ok',
                'nested1' => [
                    'firstkey' => 'firstvalue',
                    'finalkey' => 'finalvalue'
                ]
            ],
            'parameter2' => 'there'
        ];
        $messager = new Messager(
            $this->createMock(EngineInterface::class),
            $this->createMock(\Swift_Mailer::class),
            new Request()
        );

        $parameter = $messager
            ->setParameters($parameters)
            ->getParameter('parameter1.value1');
        $this->assertEquals('ok', $parameter);

        $parameter = $messager
            ->setParameters($parameters)
            ->getParameter('parameter1.nested1.finalkey');
        $this->assertEquals('finalvalue', $parameter);
    }
}
