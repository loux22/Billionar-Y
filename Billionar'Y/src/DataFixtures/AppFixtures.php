<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Note;
use App\Entity\User;
use App\Entity\Member;
use App\Entity\Historic;
use App\Entity\RankingWinning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new User;
            $user->setUsername("username" . $i);
            $user->setLastname("Lastname" . $i);
            $user->setMail("user" . $i . '@gmail.com');
            $user->setPassword('$2y$13$mr3n5CzPnvTlhH2rjforreZDgoDeHfZUvTy2ksQtr484FyDZT.Re2');
            $user->setAvatar("0.png");
            $user->setDateU(new \DateTime());
            $user->setIsActive(true);
            $user->setPseudo("user" . $i);
            $user->setAge(new \DateTime('1998-01-22'));
            $manager->persist($user);

            $member = new Member;
            $member->setBank(0);
            $member->setUser($user);
            $manager->persist($member);
        }

        for ($j = 0; $j < 9; $j++) {
            $game = new Game;
            $game->setName("game" . $j);
            $game->setDescriptionG("description trop genial, on se regale " . $j);
            $game->setIsActive(true);
            $game->setNbPlay(rand(100, 10000));
            $game->setImg('default.jpg');
            $game->setWinningsMax(rand(100, 100000));
            $manager->persist($game);

            for ($r=0; $r < 15; $r++) { 
                $ranking = new RankingWinning;
                $ranking 
                    -> setIdMember($member)
                    -> setIdGame($game)
                    -> setWinning(rand(0,100000))
                    -> setDateR(new \DateTime());
                $manager->persist($ranking);
            }

            for ($l = 0; $l < 10; $l++) {
                $note = new Note;
                $note->setMember($member);
                $note->setGame($game);
                $note->setNote(rand(0, 5));
                $manager->persist($note);
            }
            for ($i = 0; $i < 5; $i++) {
                $historic = new Historic;
                $historic->setGame($game);
                $historic->setDate(new \DateTime('1998-01-2' . $j));
                $historic->setNbParty(rand(1, 1000));
                $historic->setTotal(rand(0, 10000));
                $historic->setUser($user);
                $manager->persist($historic);
            }
        }

        $manager->flush();
    }
}
