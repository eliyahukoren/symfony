<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = array(
            array('author_1', 'Terry', 'Pratchett', 'Terry Pratchett sold his first story when he was fifteen, which earned him enough money to buy a second-hand typewriter.'),
            array('author_2', 'Nell', 'Gaiman', 'Neil Gaiman is the #1 New York Times bestselling author of more than twenty books, including Norse Mythology, Neverwhere, and The Graveyard Book.'),
            array('author_3', 'Saul', 'Herzog', 'Saul Herzog is the pen name of one of the publishing industry\'s most successful and sought after thriller authors. '),
            array('author_4', 'James', 'Patterson', 'James Patterson is the world\'s bestselling author. The creator of Alex Cross, he has produced more enduring fictional heroes'),
            array('author_5', 'Richard', 'DiLallo', 'French Twist: Gorgeous women are dropping dead at upscale department stores in New York City. '),
        );

        $arr = array();
        foreach ($authors as $author) {
            $a = new Author();
            $a->setFirstName($author[1]);
            $a->setLastName($author[2]);
            $a->setNotes($author[3]);
            $arr[] = $a;
        }

        foreach ($arr as $x) {
            $manager->persist($x);
        }
        //
        $manager->flush();
        $this->addReference('author_1', $arr[0]);
        $this->addReference('author_2', $arr[1]);
        $this->addReference('author_3', $arr[2]);
        $this->addReference('author_4', $arr[3]);
        $this->addReference('author_5', $arr[4]);

    }
}
