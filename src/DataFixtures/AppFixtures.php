<?php

namespace App\DataFixtures;

use Faker;
use DateTime;
use DateInterval;
use App\Entity\User;
use App\Entity\InterestType;
use App\Entity\SubscribType;
use App\Entity\Subscription;
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
        // Define Genders (W=Woman / M=Man)
        $genders=array('W', 'M');
        // Define Situations (C=Couple / S=Single / W=Widow)
        $situations=array('C', 'S', 'W');
        // Define Interests
        $interests=array('Littérature', 'Cinéma', 'Théatre', 'Concert/Opéra',
            'Musique', 'Art/Histoire', 'Cuisine', 'Nouvelles technologies',
            'Sciences', 'Sport', 'Politique', 'Mode', 'Animaux',
            'Jeux de société', 'Jeux de rôle', 'Jeux d\'argent',
            'Nouvelle rencontre'    
        );
        // Define Subscription type
        $subscriptions=array(
            [
               'type' => 'Occasionnelle/Occasionnel',
               'duration' => 1,
               'durationType' => 'W',
               'price' => 8.99 
            ],
            [
                'type' => 'Ponctuelle/Ponctuel',
                'duration' => 1,
                'durationType' => 'M',
                'price' => 29,99 
             ],
             [
                'type' => 'Temporaire/Temporaire',
                'duration' => 3,
                'durationType' => 'M',
                'price' => 74.97 
             ],
             [
                'type' => 'Régulière/Régulier',
                'duration' => 6,
                'durationType' => 'M',
                'price' => 119.94 
             ],
             [
                'type' => 'Permanente/Permanent',
                'duration' => 1,
                'durationType' => 'Y',
                'price' => 191.88 
             ]
        );

        $subscribes=array(true, false);
        
        // Set interest type
        foreach ($interests as $value){
            $interest=new InterestType();
            $interest->setName($value);
            $manager->persist($interest);
        }

        // Set subscription type
        $subscriptionArray=[];
        foreach($subscriptions as $subscription){
            $subscribType = new SubscribType();
            $subscribType   -> setType($subscription['type'])
                            -> setDuration($subscription['duration'])
                            -> setDurationType(($subscription['durationType']))
                            -> setPrice($subscription['price']);
            $manager->persist($subscribType);
            $subscriptionArray[]=$subscribType;
        }

        
        for ($i=0; $i<20; $i++){

            $user = new User();

            // generate randomly if subscribed or not
            $subscribed=$subscribes[mt_rand(0, count($subscribes)-1)];

            // generate randomly situation
            $situation=$situations[mt_rand(0,count($situations)-1)];

            // generate randomly the gender
            $gender=$genders[mt_rand(0, count($genders)-1)];

             // Generate firstname and avatar following the gender
            $firstName = ($gender=='M' ? $faker->firstNameMale : $faker->firstNameFemale);

            // Generate a picture
            $picture='https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberbetween(1,99) . '.jpg';
            $picture .= ($gender=='M' ? 'men/' : 'women/') .$pictureId;
            
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
                    -> setSubscribed($subscribed)
                    -> setCompleted(38);

            $manager->persist($user);

            // Create subscription
                    
            if ($subscribed){
                $dateBegin=new DateTime();
                $subscription=$subscriptionArray[mt_rand(0, count($subscriptionArray)-1)];
                switch($subscription->getDurationType()){
                    case "W":
                        $dateBegin=$faker->dateTimeBetween('-6 days','-1 day');
                        break;
                    case 'M':
                        switch($subscription->getDuration()){
                            case 1:
                                $dateBegin=$faker->dateTimeBetween('-20 days','-3 days');
                                break;
                            case 3:
                                $dateBegin=$faker->dateTimeBetween('-2 months','-5 days');
                                break;
                            case 6:
                                $dateBegin=$faker->dateTimeBetween('-4 months','-1 month');
                                break;
                        }
                    break;
                    case 'Y':
                        $dateBegin=$faker->dateTimeBetween('-10 months','-20 days');
                        break;

                }
                $dateEnd=clone $dateBegin;
                $interval="P".$subscription->getDuration().$subscription->getDurationType();
                $dateEnd->add(new DateInterval($interval));
                $subscribe=new Subscription();
                $subscribe  -> setSubscriber($user)
                            -> setSubscriberType($subscription)
                            -> setSubscribPaidAt($dateBegin)
                            -> setSubscribBeginAt($dateBegin)
                            -> setSubscribEndAt($dateEnd)
                            -> setActive(true);

                $manager->persist($subscribe);
            }
        }
        $manager->flush();
    }   
}
