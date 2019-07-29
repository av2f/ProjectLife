<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
    }
    
   /**
    * Generate randomly a pseudo
    * 
    * Author    : F. Parmentier
    * Created   : 2019/07/29
    *
    * @param string $firstName
    * @param string $lastName
    * @return string
    */
    private function createPseudo(string $firstName, string $lastName): string {
        $number=(string)mt_rand(120,999);
        $firstN=(strlen($firstName)>5) ? substr($firstName,0,strlen($firstName)-3) : $firstName;
        $lastN=(strlen($lastName)>5) ? substr($lastName,0,strlen($lastName)-3) : $lastName;
        
        return $firstN.$lastN.$number;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $genders=['male','female'];
        
        for ($i=0; $i<20; $i++){

            $user = new User();
            
            // define randomly the gender of user
            $gender=$faker->randomElement($genders);
            $birthDate= new \DateTime();
            $birthDate=$faker->dateTimeBetween('-60 years','-20 years');

            $user   -> setPseudo($this->createPseudo($faker->firstName($gender), $faker->lastName($gender)))
                    -> setEmail($faker->email)
                    -> setPassword($this->encoder->encodePassword($user,'password'))
                    -> setBirthdayDate($birthDate->format('Y-m-d'))
                    -> setAge(30)
                    -> setDecription($faker->sentence())
                    -> setCreatedAt($faker->dateTime('now'))
                    -> setModifiedAt($faker->dateTime('now'));

            $manager->persist($user);
        }

        $manager->flush();
    }   
}
