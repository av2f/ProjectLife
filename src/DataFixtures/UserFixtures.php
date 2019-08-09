<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder=$passwordEncoder;
    }
    
   /**
    * Generate randomly a pseudo
    * 
    * Author    : F. Parmentier
    * Created   : 2019/07/29
    *
    * @param string $firstName
    * @return string
    */
    private function createPseudo(string $firstName): string {
        $number=(string)mt_rand(120,999);
        $firstN=(strlen($firstName)>5) ? substr($firstName,0,strlen($firstName)-3) : $firstName;
        $pseudo=mb_strtolower($firstN).$number;
        // $trans = array("é" => "e", "à" => "a");
        $pseudo = preg_replace('[éèêë]','e',$pseudo);
        // $pseudo = strtr($pseudo,$trans);
        dump($pseudo);
        return $pseudo;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        $gender1 = new Gender();
        $gender1->setGenderFr('Femme');
        $manager->persist($gender1);
        $gender2 = new Gender();
        $gender2->setGenderFr('Homme');
        $manager->persist($gender2);

        
        for ($i=0; $i<20; $i++){

            $user = new User();

            // define randomly the gender for user
            $genderId = mt_rand(1,2);
            $gender = ($genderId==2 ? $gender2 : $gender1);
            $nameGender = ($genderId==2 ? 'male' : 'female');
            dump($gender);

            // define a birthday date
            $birthDate= new \DateTime();
            $birthDate=$faker->dateTimeBetween('-60 years','-20 years');
            // Generate a picture
            $picture='https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberbetween(1,99) . '.jpg';
            $picture .= ($genderId==2 ? 'men/' : 'women/') .$pictureId;

            // CreatedAt is generated with prePersist function
            $user   -> setPseudo($this->createPseudo($faker->firstName($nameGender)))
                    -> setEmail($faker->email)
                    -> setPassword($this->passwordEncoder->encodePassword($user,'password'))
                    -> setAvatar($picture)
                    -> setBirthdayDate($birthDate)
                    -> setDescription($faker->sentence())
                    -> setGender($gender);

            $manager->persist($user);
        }

        $manager->flush();
    }   
}
