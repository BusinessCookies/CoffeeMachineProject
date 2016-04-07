<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \DateTime;
use AppBundle\Entity\Data;
use AppBundle\Form\DataType;

class RaspiController extends Controller
{

		/**
     * @Route("/raspi/update", name="raspi_update")
		 * @Method({"POST"})
     */
		public function update(Request $request)
    {
      // Get repositories
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Data');
      
      // Register the connection
      $connectiondata = $repository->findOneByFile("Connections");
      $date = new DateTime();
      $connectiondata->SetData(trim($connectiondata->GetData())."\n".$date->format('YmdHis'));
      $em->persist($connectiondata);
      
      // Get the posted data and remove everything outside csv
			$addedData = $request->request->get('date');
			$addedData = trim($addedData);
			
			// Get current date and remove everything outside csv
      $datedata = $repository->findOneByFile("Date");
      $newData = $datedata->GetData();
      $newData = trim($newData);
      $newData = $newData."\n".$addedData;
      $datedata->SetData($newData);
      $em->persist($datedata);
      
      // Get Traceback
      $tracedata = $repository->findOneByFile("Traceback");
      $newtraceData = $tracedata->GetData();
      $newtraceData = trim($newtraceData);
      
      // Update Admin Data
      $admindata = $repository->findOneByFile("Admin");
      $csvadmin = $this->parseCSV($admindata->GetData(), ";", "\n");
      $csvdate = $this->parseCSV($addedData, ";", "\n");
      foreach($csvdate as $eda)
      {
        foreach($csvadmin as &$ead)
        {
          if( $eda[1] === $ead[0])
          {
						$actualmoney = floatval($ead[2]);
						$toremove = ($actualmoney<0)*0.40 + ($actualmoney>=0)*0.25;
            $ead[2] = number_format($actualmoney - $toremove,2,'.','');
            // Update traceback
            $date = new DateTime();
            $addstring = $ead[0].";".$date->format('YmdHis').";".$eda[0].";".number_format(-1*$toremove,2,'.','').";".$ead[2];
            $newtraceData = $newtraceData."\n".$addstring;
          }
        }
      }
      $tracedata->SetData($newtraceData); 
      $em->persist($tracedata);
      
      $admindata->SetData($this->unparseCSV($csvadmin, ";", "\n"));
      $em->persist($admindata);
      $em->flush();
      
      return new Response(trim($admindata->GetData()));
    }
    
    
    private function parseCSV($CsvString, $delimiter, $stopper)
    {
      // Clean string
      $CsvString = trim($CsvString);
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
      return trim($string);
    }
}
