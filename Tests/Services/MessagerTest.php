<?php

namespace tests\TLH\ContactBundle\Services;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use TLH\ContactBundle\Services\Messager;
use Twig\Environment;

class MessagerTest extends TestCase
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
            $this->createMock(Environment::class),
            $this->createMock(\Swift_Mailer::class),
            new RequestStack()
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
