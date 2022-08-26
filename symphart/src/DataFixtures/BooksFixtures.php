<?php

namespace App\DataFixtures;

use App\Entity\Book;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BooksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $books = array(
            array('13-978-0060153983', array('author_1', 'author_2'), 'Good Omens', '2006', 'The classic collaboration from the internationally bestselling authors Neil Gaiman and Terry Pratchett', 'https://m.media-amazon.com/images/I/91hmKjgP+kL._AC_UY218_.jpg'),
            array('13-979-0060253983', array('author_1'), 'The Color of Magic', '2018', 'I start touring 6 weeks from now. It\'s the first time I\ve done something like this since before Covid ', 'https://m.media-amazon.com/images/I/81vK4lq1HSL.SR160,240_BG243,243,243.jpg'),
            array('13-972-0060353983', array('author_1'), 'Mort', '2019', 'So, let\'s see. I was the castaway on Desert Island Discs. This probably doesn\'t mean anything to anyone who isn\'t from the UK.', 'https://m.media-amazon.com/images/I/719kPax+LZL.SR160,240_BG243,243,243.jpg'),
            array('13-970-0064853983', array('author_2'), 'Sandman', '2020', 'notes', 'https://m.media-amazon.com/images/I/81B3W3Fa+bL.SR160,240_BG243,243,243.jpg'),
            array('13-942-0060855983', array('author_3'), 'The Asset', '2017', 'Montana, USA When Lance Spector quit the CIA, he swore he was out for good. ', 'https://m.media-amazon.com/images/I/81JgX8VgZiL.SR160,240_BG243,243,243.jpg'),
            array('13-915-0060855341', array('author_4'), 'The Paris Detective', '2021', 'The most revered detective in Paris puts his skills to the test in three thrilling cases from the creator of Alex Cross and Detective Michael Bennett.', 'https://m.media-amazon.com/images/I/81KIipMFkWL._AC_UY218_.jpg'),
        );

        $arr = array();
        foreach( $books as $book ){
            $b = new Book();
            $b->setISBN($book[0]);
            $b->setTitle($book[2]);
            $b->setPublishDate($book[3]);
            $b->setNotes($book[4]);
            $b->setImagePath($book[5]);
            foreach($book[1] as $item){
                $b->addAuthor($this->getReference($item));
            }

            $arr[] = $b;
        }

        foreach($arr as $a){
            $manager->persist($a);
        }
        //
        $manager->flush();

    }
}
