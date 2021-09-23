<?php

namespace App\Test\Entity;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\Date;

class BookEntityTest extends KernelTestCase
{
    public function testValidEntity()
    {
        $book = (new Book())
            ->setTitle('testTitle')
            ->setAuthor('testAuthor')
            ->setIsbn13(9782123456803)
            ->setSummary('testSummary')
            ->setDate(new \DateTime('now'));
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($book);
        $this->assertCount(0, $errors);
    }
    public function testInvalidEntity()
    {
        $book = (new Book())
            // Title and author should not be null

            ->setIsbn13(9782123456803)
            ->setSummary('testSummary')
            ->setDate(new \DateTime('now'));
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($book);
        $this->assertCount(2, $errors);
    }
}
