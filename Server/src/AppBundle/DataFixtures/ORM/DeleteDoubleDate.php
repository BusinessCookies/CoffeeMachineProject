<?php
namespace AppBundle\DataFixtures\ORM;

// src/AppBundle/DataFixtures/ORM/DeleteDoubleDate.php
// php app/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/ORM/ --append

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Data;

class DeleteDoubleDate implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
			// Get date adn admin data
      $repository = $manager->getRepository('AppBundle:Data');
			$admin_data = $repository->findOneByFile("Admin");
      $date_data = $repository->findOneByFile("Date");
      
      // Update the data, checking duplicate data:
			// --> delete the Date line
			// --> add 0.25 c to corresponding Admin 

      $csv_admin = $this->parseCSV($admin_data->GetData(), ";", "\n");
      $csv_date = $this->parseCSV($date_data->GetData(), ";", "\n");
			$lastIndex = count($csv_date)-1; // last index
      for ($i = 0; $i < $lastIndex; $i++) // for each date
      {
				for ($j = $i+1; $j <= $lastIndex; $j++) // for each other date data
				{
					if($csv_date[$i][0] === $csv_date[$j][0]) // if date[j] has the same datetime
					{
					  foreach($csv_admin as &$admin_line) // for each admin
					  {
					    if( $csv_date[$i][1] === $admin_line[0]) // if admin correspond to ID of the date
					    {
								$actualmoney = floatval($admin_line[2]); // get admin's current money
								$toadd = 0.25; // add money depending on his current account state
					      $admin_line[2] = number_format($actualmoney + $toadd,2,'.',''); // replace admin's current money
					    }
					  }
						array_splice($csv_date, $j, 1); // delete duplicated element
						$lastIndex--; // decrease the lastIndex
						$j--;
					}
				}
      }

			// Update Data in DB
      $admin_data->SetData($this->unparseCSV($csv_admin, ";", "\n"));
			$date_data->SetData($this->unparseCSV($csv_date, ";", "\n"));
      $manager->persist($date_data);
      $manager->persist($admin_data);
      $manager->flush();
    }

		private function parseCSV($CsvString, $delimiter, $stopper)
    {
			// This will create a table in any case, will be len = 1 if nothing in csvstring
      $Data = explode($stopper, $CsvString); //parse the rows
      foreach($Data as &$Row)
      {
       $Row = explode($delimiter, $Row); //parse the items in rows 
      }
			// if csvstring is empty data[0][0] == csvstring
			if($Data[0][0] == $CsvString)
			{
				return array();
			} 
      return $Data;
    }
    
    private function unparseCSV($CsvString, $delimiter, $stopper)
    {
      $string = "";
      foreach($CsvString as &$line)
      {
        $substring = "";
        $iter = 0;
        foreach($line as &$c)
        {
          if($iter!=0)
          {
            $substring = $substring.$delimiter;
          }
          $substring = $substring.$c;
          $iter=$iter+1;
        }
       $string = $string.$substring.$stopper;
      }
      return $string;
    }
}

