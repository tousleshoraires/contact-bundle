<?php

namespace Tests\TLH\ContactBundle\Services;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use TLH\ContactBundle\Services\Messager;
use TLH\ContactBundle\Services\MessagerInterface;
use Twig\Environment;

class MessagerTest extends TestCase
{
    /**
     * @test
     * @group Services
     */
    #[Test]
    #[Group('Services')]
   public function itIsInstantiable(): void
    {
        $messager = new Messager(
            $this->createMock(Environment::class),
            $this->createMock(MailerInterface::class),
            new RequestStack()
        );

        $this->assertInstanceOf(MessagerInterface::class, $messager);
    }

    /**
     * @test
     * @group Services
     */
     #[Test]
     #[Group('Services')]
    public function getParameter(): void
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
            $this->createMock(MailerInterface::class),
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

    #[Test]
    #[Group('Services')]
    public function confirmationEmail(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects(self::once())->method('send');

        $requestStack = new RequestStack();
        $requestStack->push(new \Symfony\Component\HttpFoundation\Request());

        $twig = $this->createMock(Environment::class);
        $twig->expects(self::once())->method('render')->willReturn('Yes');

        $messager = new Messager(
            $twig,
            $mailer,
            $requestStack
        );
        $messager->setParameters(['confirmation' => ['from_email' => ['address' => 'lorem@ipsum.com']], 'recipient_address' => 'received@tlh.fr']);
        $messager->sendConfirmationEmailMessage([], '');
    }
}
