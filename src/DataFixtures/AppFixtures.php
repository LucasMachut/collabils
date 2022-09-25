<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Category;
use App\Services\SlugService;
use App\Entity\Request;
use App\Entity\Video;
use App\Entity\User;
use Doctrine\DBAL\Connection;

class AppFixtures extends Fixture
{
    private $slug;
    private $slugService;
    private $connection;

    public function __construct(SlugService $slug, Connection $connection) {
        $this->slug = $slug;
        $this->connection = $connection;
    }

    private function truncate()
    {
        //* disable foreign key check for this connection before truncating the tables
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');
        $this->connection->executeQuery('TRUNCATE TABLE category');
        $this->connection->executeQuery('TRUNCATE TABLE request');
        $this->connection->executeQuery('TRUNCATE TABLE video');
        $this->connection->executeQuery('TRUNCATE TABLE user');
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');
    }


    public function load(ObjectManager $manager, SlugService $slug):void
    {
        //Add truncate function to set id to 1
        $this->truncate();

        // Instaciation faker factory
        $faker = Faker\Factory::create('fr_FR');

        $categoryList = [];
        $videoList = [];
        $requestList = [];
        $userList = [];

        //* USER CREATION

        $userAdmin = new User();
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setFirstName('admin');
        $userAdmin->setLastName('admin');
        $userAdmin->setSlug($this->slugService->slug($userAdmin->getFirstName()));
        $userAdmin->setPassword('admin');
        $userAdmin->setStatus(1);
        $userAdmin->setJob('interprete');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userList[] = $userAdmin;

        $userLambda1 = new User();
        $userLambda1->setEmail('user1@user1.com');
        $userLambda1->setFirstName('user1');
        $userLambda1->setLastName('user1');
        $userLambda1->setSlug($this->slugService->slug($userAdmin->getFirstName()));
        $userLambda1->setPassword('user1');
        $userLambda1->setStatus(1);
        $userLambda1->setJob('interprete');
        $userLambda1->setRoles(['ROLE_USER']);
        $userList[] = $userAdmin;

        $userLambda2 = new User();
        $userLambda2->setEmail('user2@user2.com');
        $userLambda2->setFirstName('user2');
        $userLambda2->setLastName('user2');
        $userLambda2->setSlug($this->slugService->slug($userAdmin->getFirstName()));
        $userLambda2->setPassword('user2');
        $userLambda2->setStatus(1);
        $userLambda2->setJob('interprete');
        $userLambda2->setRoles(['ROLE_USER']);
        $userList[] = $userLambda2;

        $manager->persist($userAdmin);
        $manager->persist($userLambda1);
        $manager->persist($userLambda2);


        //* CATEGORY CREATION
                
        $category1 = new Category();
        $category1->setName('Physique');
        $categorySlug1 = $this->slugService->slug($category1->getName())->lower();
        $category1->setSlug($categorySlug1);
        $manager->persist($category1);
        $categoryList[] = $category1;

        $category2 = new Category();
        $category2->setName('Psychologie');
        $categorySlug2 = $this->slugService->slug($category2->getName())->lower();
        $category2->setSlug($categorySlug2);
        $manager->persist($category2);
        $categoryList[] = $category2;

        $category3 = new Category();
        $category3->setName('Justice');
        $categorySlug3 = $this->slugService->slug($category3->getName())->lower();
        $category3->setSlug($categorySlug3);
        $manager->persist($category3);
        $categoryList[] = $category3;


        //* REQUEST CREATION
        for ($j = 0; $j < 30; $j++) {
            $request = new Request();
            $request->setTitle($faker->sentence(true));
            $request->setDefinition($faker->sentence(true));
            $request->setContext($faker->sentence(true));
            $request->setCategory($categoryList[array_rand($categoryList)]);
            $date=$faker->date('Y-m-d');
            $request->setCreatedAt(new \DateTime($date));
            $request->setStatus($faker->numberBetween(0, 1));
            
            $manager->persist($request);
            $requestList[] = $request;
        }

        //* VIDEO CREATION
        for($l = 0; $l < 30; $l++) {
            $video = new Video();
            $video->setTitle($faker->sentence(true));
            $video->setDefinition($faker->sentence(true));
            $video->setContext($faker->sentence(true));
            $video->setSlug($this->slugService->slug($video->getTitle()));
            $video->setCategory($categoryList[array_rand($categoryList)]);
            $videoDate = $faker->date('Y-m-d');
            $video->setUpdatedAt(new \DateTime($videoDate));
            $video->setStatus($faker->numberBetween(0, 1));
            $video->setAuthor($userList[array_rand($userList)]);

            $manager->persist($video);
            $practiceList[] = $video;
        }

        $manager->flush();
    }
}
