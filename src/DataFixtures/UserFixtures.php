<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
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
    * @param string $lastName
    * @return string
    */
    private function createPseudo(string $firstName, string $lastName): string {
        $number=(string)mt_rand(120,999);
        $firstN=(strlen($firstName)>5) ? substr($firstName,0,strlen($firstName)-3) : $firstName;
        $lastN=(strlen($lastName)>5) ? substr($lastName,0,strlen($lastName)-3) : $lastName;
        $pseudo=$firstN.$lastN.$number;
        dump($pseudo);
        return $pseudo;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $genders=['male','female'];
        
        for ($i=0; $i<20; $i++){

            $user = new User();
            
            // define randomly the gender of user
            $gender=$faker->randomElement($genders);
            // define a birthday date
            $birthDate= new \DateTime();
            $birthDate=$faker->dateTimeBetween('-60 years','-20 years');
            // Generate a picture
            $picture='https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberbetween(1,99) . '.jpg';
            $picture .= ($gender=='male' ? 'men/' : 'women/') .$pictureId;

            $user   -> setPseudo($this->createPseudo($faker->firstName($gender), $faker->lastName($gender)))
                    -> setEmail($faker->email)
                    -> setPassword($this->passwordEncoder->encodePassword($user,'password'))
                    -> setAvatar($picture)
                    -> setBirthdayDate($birthDate)
                    -> setAge(30)
                    -> setDescription($faker->sentence())
                    -> setCreatedAt($faker->dateTime('2019-07-29'))
                    -> setLastModified($faker->dateTime('2019-07-29'));

            $manager->persist($user);
        }

        $manager->flush();
    }   
}
