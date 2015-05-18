<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\SwiftmailerDoctrineBundle\Tests\Entity;

use Sonatra\Bundle\SwiftmailerDoctrineBundle\Model\Repository\SpoolEmailRepositoryInterface;

/**
 * SpoolEmail Repository Tests.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class SpoolEmailRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFindEmailsToSend()
    {
        /* @var SpoolEmailRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repo */
        $repo = $this->getMockBuilder('Sonatra\Bundle\SwiftmailerDoctrineBundle\Entity\Repository\SpoolEmailRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('createQueryBuilder'))
            ->getMock()
        ;

        $q = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(array('setParameter', 'getResult'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $q->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue(array()));

        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $qb->expects($this->any())
            ->method('where')
            ->will($this->returnSelf());
        $qb->expects($this->any())
            ->method('orderBy')
            ->will($this->returnSelf());
        $qb->expects($this->any())
            ->method('setParameter')
            ->will($this->returnSelf());
        $qb->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($q));

        $repo->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($qb))
        ;

        $this->assertSame(array(), $repo->findEmailsToSend(1));
    }

    public function testRecover()
    {
        /* @var SpoolEmailRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject $repo */
        $repo = $this->getMockBuilder('Sonatra\Bundle\SwiftmailerDoctrineBundle\Entity\Repository\SpoolEmailRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('getEntityManager'))
            ->getMock()
        ;

        $q = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(array('setParameter', 'execute'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $q->expects($this->any())
            ->method('setParameter')
            ->will($this->returnSelf());

        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $em->expects($this->any())
            ->method('createQuery')
            ->will($this->returnValue($q));

        $repo->expects($this->any())
            ->method('getEntityManager')
            ->will($this->returnValue($em));

        $repo->recover(900);
    }
}
