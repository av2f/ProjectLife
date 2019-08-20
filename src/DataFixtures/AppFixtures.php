<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Gender;
use App\Entity\Situation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
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
        $search=array("/é/","/è/","/ê/","/ë/");
        $pseudo = preg_replace($search,'e',$pseudo);
        return $pseudo;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $genders=array('Femme', 'Homme');
        $subscribes=array(true, false);
        $situations=array('En couple', 'Célibataire', 'Veuve/veuf');
        
        // define gender
        $genderArray=[];
        foreach($genders as $value) {
            $gender=new Gender();
            $gender->setTitle($value);
            $manager->persist($gender);
            $genderArray[]=$gender;
        }

        // define situation
        $situationArray=[];
        foreach($situations as $value){
            $situation=new Situation();
            $situation->setType($value);
            $manager->persist($situation);
            $situationArray[]=$situation;
        }
        
        for ($i=0; $i<20; $i++){

            $user = new User();

            // choose randomly situation
            $situation=$situationArray[mt_rand(0,count($situationArray)-1)];
            // choose randomly the gender
            $gender=$genderArray[mt_rand(0, count($genderArray)-1)];
            
            // Generate firstname and avatar following the gender
            $genderToArray=(array)$gender;
            foreach($genderToArray as $key => $value) { 
                $firstName = ($value=='Homme' ? $faker->firstNameMale : $faker->firstNameFemale);
                // Generate a picture
                $picture='https://randomuser.me/api/portraits/';
                $pictureId=$faker->numberbetween(1,99) . '.jpg';
                $picture .= ($value=='Homme' ? 'men/' : 'women/') .$pictureId;
            }
            
            // define a birthday date
            $birthDate= new \DateTime();
            $birthDate=$faker->dateTimeBetween('-60 years','-20 years');

            // Create new user
            // CreatedAt is generated with prePersist function
            $user   -> setPseudo($this->createPseudo($firstName))
                    -> setEmail($faker->email)
                    -> setPassword($this->passwordEncoder->encodePassword($user,'password'))
                    -> setFirstName($firstName)
                    -> setLastName($faker->lastName)
                    -> setAvatar($picture)
                    -> setBirthdayDate($birthDate)
                    -> setSituation($situation)
                    -> setDescription($faker->sentence())
                    -> setGender($gender)
                    -> setSubscribed($subscribes[mt_rand(0, count($subscribes)-1)]);

            $manager->persist($user);
        }

        $manager->flush();
    }   
}
