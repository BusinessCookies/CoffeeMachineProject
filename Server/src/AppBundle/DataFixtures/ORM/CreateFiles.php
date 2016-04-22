<?php
namespace AppBundle\DataFixtures\ORM;

// src/AppBundle/DataFixtures/ORM/CreateFiles.php
// php app/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/ORM/ --append

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Data;

class CreateFiles implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
			// Create needed file if don't exist
      $types = ['Date', 'Admin', 'Traceback', 'Connections', 'ExpCoffee', 'NormCoffee', 'UpdatedLabel', 'MinMoney', 'QuestionnaireDanke', 'QuestionnaireWelcome', 'Grade', 'Grade2'];
      $repository = $manager->getRepository('AppBundle:Data');
      foreach($types as $type)
      {
        $data = $repository->findOneByFile($type);
        if($data == null)
        {
          $data = new Data();
          $data->SetData('');
          $data->SetFile($type);
          $manager->persist($data);
          $manager->flush();
        }
      }
    }
}
