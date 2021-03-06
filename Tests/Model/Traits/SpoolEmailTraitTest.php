<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\SwiftmailerDoctrine\Tests\Entity;

use Fxp\Component\SwiftmailerDoctrine\SpoolEmailStatus;
use Fxp\Component\SwiftmailerDoctrine\Tests\Fixtures\Entity\SpoolEmail;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * SpoolEmail Trait Tests.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SpoolEmailTraitTest extends TestCase
{
    public function testDefaultValue(): void
    {
        $message = $this->createSwiftMessage();
        $sp = new SpoolEmail();

        $this->assertNull($sp->getMessage());
        $sp->setMessage($message);
        $this->assertEquals($message, $sp->getMessage());
        $this->assertNull($sp->getSentAt());
        $this->assertSame(SpoolEmailStatus::STATUS_WAITING, $sp->getStatus());
        $this->assertNull($sp->getStatusMessage());
    }

    public function testEdition(): void
    {
        $message = $this->createSwiftMessage();
        $sp = new SpoolEmail();

        $sp->setMessage($message);
        $this->assertEquals($message, $sp->getMessage());

        $date = new \DateTime();
        $sp->setSentAt($date);
        $this->assertSame($date, $sp->getSentAt());
        $sp->setSentAt(null);
        $this->assertNull($sp->getSentAt());

        $sp->setStatus(SpoolEmailStatus::STATUS_SENDING);
        $this->assertSame(SpoolEmailStatus::STATUS_SENDING, $sp->getStatus());

        $statusMsg = 'Status message';
        $sp->setStatusMessage($statusMsg);
        $this->assertSame($statusMsg, $sp->getStatusMessage());
        $sp->setStatusMessage(null);
        $this->assertNull($sp->getStatusMessage());
    }

    /**
     * @return MockObject|\Swift_Mime_SimpleMessage
     */
    protected function createSwiftMessage()
    {
        return $this->getMockBuilder('Swift_Mime_SimpleMessage')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
