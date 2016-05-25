<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Data;
use AppBundle\Entity\AddMoney;
use AppBundle\Form\AddMoneyType;
use AppBundle\Entity\AddUser;
use AppBundle\Form\AddUserType;
use AppBundle\Form\DataType;
use \DateTime;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
      
    /**
     * @Route("/admin/getQuestionnaireDanke", name="admin_getquestionnairedanke")
     */
    public function getQuestionnaireDanke(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("QuestionnaireDanke");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file QuestionnaireDanke");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "QuestionnaireDanke", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyQuestionnaireDanke", name="admin_modifyquestionnairedanke")
     */
    public function modifyQuestionnaireDanke(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("QuestionnaireDanke");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "QuestionnaireDanke", 'form' => $form->createView()));
    }    
    
    /**
     * @Route("/admin/getQuestionnaireWelcome", name="admin_getquestionnairewelcome")
     */
    public function getQuestionnaireWelcome(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("QuestionnaireWelcome");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file QuestionnaireWelcome");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "QuestionnaireWelcome", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/getGrade", name="admin_getgrade")
     */
    public function getGrade(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Grade");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file Grade");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "Grade", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyGrade", name="admin_modifygrade")
     */
    public function modifyGrade(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Grade");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "Grade", 'form' => $form->createView()));
    }    
    
    /**
     * @Route("/admin/getGrade2", name="admin_getgrade2")
     */
    public function getGrade2(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Grade2");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file Grade2");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "Grade2", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyGrade2", name="admin_modifygrade2")
     */
    public function modifyGrade2(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Grade2");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "Grade2", 'form' => $form->createView()));
    }    
    
    
    
    /**
     * @Route("/admin/modifyQuestionnaireWelcome", name="admin_modifyquestionnairewelcome")
     */
    public function modifyQuestionnaireWelcome(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("QuestionnaireWelcome");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "QuestionnaireWelcome", 'form' => $form->createView()));
    }    
    
    /**
     * @Route("/admin/getMinMoney", name="admin_getminmoney")
     */
    public function getMinMoney(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("MinMoney");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file MinMoney");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "MinMoney", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyMinMoney", name="admin_modifyminmoney")
     */
    public function modifyMinMoney(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("MinMoney");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "MinMoney", 'form' => $form->createView()));
    }
    
    /**
     * @Route("/admin/getUpdatedLabel", name="admin_getupdatedlabel")
     */
    public function getUpdatedLabel(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("UpdatedLabel");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file UpdatedLabel");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "UpdatedLabel", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyUpdatedLabel", name="admin_modifyupdatedlabel")
     */
    public function modifyUpdatedLabel(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("UpdatedLabel");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "UpdatedLabel", 'form' => $form->createView()));
    }
    
    /**
     * @Route("/admin/getNormCoffee", name="admin_getnormcoffee")
     */
    public function getNormCoffee(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("NormCoffee");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file NormCoffee");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "NormCoffee", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyNormCoffee", name="admin_modifynormcoffee")
     */
    public function modifyNormCoffee(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("NormCoffee");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "NormCoffee", 'form' => $form->createView()));
    }

    /**
     * @Route("/admin/getExpCoffee", name="admin_getexpcoffee")
     */
    public function getExpCoffee(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("ExpCoffee");
      if (null === $data) {
        throw new NotFoundHttpException("Could not find the file ExpCoffee");
      }
      return $this->render('AppBundle:Admin:getData.html.twig', array('datatype' => "ExpCoffee", 'data' => $data->GetData()));
    }
    
    /**
     * @Route("/admin/modifyExpCoffee", name="admin_modifyexpcoffee")
     */
    public function modifyExpCoffee(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("ExpCoffee");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyData.html.twig', array('datatype' => "ExpCoffee", 'form' => $form->createView()));
    }

	
	/**
     * @Route("/admin/modifyAdminData", name="admin_modifyadmindata")
     */
    public function modifyAdminData(Request $request)
    {
	    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Admin");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
		$csvadmin = $this->parseCSV($data->GetData(), ";", "\n");
		foreach($csvadmin as &$ead)
		{
			$ead[0] = strtolower($ead[0]);
			$ead[1] = strtolower($ead[1]);
		}
		$data->SetData($this->unparseCSV($csvadmin, ";", "\n"));
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyAdminData.html.twig', array('form' => $form->createView()));
    }

	  /**
     * @Route("/admin/modifyDateData", name="admin_modifydatedata")
     */
    public function modifyDateData(Request $request)
    {
	  $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $data = $repository->findOneByFile("Date");
      $form = $this->get('form.factory')->create(new DataType(), $data);
      if ($form->handleRequest($request)->isValid()) {
        // Update Date Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Valid');
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:modifyDateData.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/admin/getAdminData", name="admin_getadmindata")
     */
    public function getAdminData(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $admindata = $repository->findOneByFile("Admin");
      if (null === $admindata) {
        throw new NotFoundHttpException("Could not find the file admin");
      }
      return $this->render('AppBundle:Admin:getAdminData.html.twig', array('admindata' => $admindata->GetData()));
    }
    
    /**
     * @Route("/admin/getDateData", name="admin_getdatedata")
     */
    public function getDateData(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $datedata = $repository->findOneByFile("Date");
      if (null === $datedata) {
        throw new NotFoundHttpException("Could not find the file admin");
      }
      return $this->render('AppBundle:Admin:getDateData.html.twig', array('datedata' => $datedata->GetData()));
    }
    
    /**
     * @Route("/admin/getTracebackData", name="admin_gettracebackdata")
     */
    public function getTracebackData(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $tracebackdata = $repository->findOneByFile("Traceback");
      if (null === $tracebackdata) {
        throw new NotFoundHttpException("Could not find the file Traceback");
      }
      return $this->render('AppBundle:Admin:getTracebackData.html.twig', array('tracebackdata' => $tracebackdata->GetData()));
    }
    
    /**
     * @Route("/admin/dataAnalysis", name="admin_dataanalysis")
     */
    public function dataAnalysis(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $tracebackdata = $repository->findOneByFile("Traceback");
      $datedata = $repository->findOneByFile("Date");
      $admindata = $repository->findOneByFile("Admin");
      $connectiondata = $repository->findOneByFile("Connections");
      if (null === $tracebackdata || null === $datedata || null === $admindata) {
        throw new NotFoundHttpException("Could not find the files");
      }
      return $this->render('AppBundle:Admin:dataAnalysis.html.twig', array('tracebackdata' => $tracebackdata->GetData(), 'datedata' => $datedata->GetData(), 'admindata' => $admindata->GetData(), 'connectiondata' => $connectiondata->GetData()));
    }
    
     /**
     * @Route("/admin/addMoney", name="admin_addmoney")
     */
    public function addMoney(Request $request)
    {
      $addMoney = new AddMoney();
      $form = $this->get('form.factory')->create(new AddMoneyType(), $addMoney);
      if ($form->handleRequest($request)->isValid()) {
        // Update Admin Data
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
        $admindata = $repository->findOneByFile("Admin");        
        $csvadmin = $this->parseCSV($admindata->GetData(), ";", "\n");
        $savemoney = 0;
        foreach($csvadmin as &$ead)
        {
          if($addMoney->GetUID() === $ead[0])
          {
            $ead[2] = number_format(floatval($ead[2]) + $addMoney->GetMoney(),2,'.','');
            $savemoney = $ead[2];
          }
        }
        $admindata->SetData($this->unparseCSV($csvadmin, ";", "\n"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($admindata);
        $em->flush();
        // Update traceback
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
        $tracedata = $repository->findOneByFile("Traceback");
        $newData = $tracedata->GetData();
        $newData = trim($newData);
        $date = new DateTime();
        $addstring = $addMoney->GetUID().";".$date->format('YmdHis').";".$date->format('YmdHis').";".$addMoney->GetMoney().";".$savemoney;
        $newData = $newData."\n".$addstring;
        $tracedata->SetData($newData);
        $em->persist($tracedata);
        $em->flush();   
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:addMoney.html.twig', array('form' => $form->createView()));
    }
    
    
    /**
     * @Route("/admin/addUser", name="admin_adduser")
     */
    public function addUser(Request $request)
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
      $admindata = $repository->findOneByFile("Admin");        
      $data = trim($admindata->GetData());
      $addUser = new AddUser();
      $addUser->SetUID( $this->generateRandomUid($data) );
      $addUser->SetPin( $this->generateRandomPin($data) );
      $addUser->SetAdmin( false );
      $addUser->SetMoney( 0 ); 
      // Generate default uID, pin, admin=false, money=0
      $form = $this->get('form.factory')->create(new AddUserType(), $addUser);
      if ($form->handleRequest($request)->isValid()) {
        // Update Admin Data
        $toAdd = $addUser->getUID().";";
        if($addUser->getAdmin() == true)
        {
          $toAdd .= "ja;";
        }else{
          $toAdd .= "nein;";
        }
        $toAdd .= $addUser->getMoney().";";
        $toAdd .= $addUser->getPin()."\n";
        $data = $data."\n".$toAdd;
        $admindata->SetData($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($admindata);
        $em->flush();
        // Update traceback
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
        $tracedata = $repository->findOneByFile("Traceback");
        $newData = $tracedata->GetData();
        $newData = trim($newData);
        $date = new DateTime();
        $addstring = $addUser->GetUID().";".$date->format('YmdHis').";".$date->format('YmdHis').";".$addUser->GetMoney().";".$addUser->GetMoney();
        $newData = $newData."\n".$addstring;
        $tracedata->SetData($newData);
        $em->persist($tracedata);
        $em->flush();   
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:addUser.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/admin/downloadBackup", name="admin_downloadbackup")
     */
    public function downloadBackup(Request $request)
    {
      // Create csv file for each file
      $types = ['Date', 'Admin', 'Traceback', 'Connections', 'ExpCoffee', 'NormCoffee', 'UpdatedLabel', 'MinMoney', 'QuestionnaireDanke', 'QuestionnaireWelcome', 'Grade', 'Grade2'];
      $path = $this->get('kernel')->getRootDir()."/../web/downloads/toZip/";
      $pathToZip = $this->get('kernel')->getRootDir()."/../web/downloads/";
      $em = $this->getDoctrine()->getManager();
	    $repository = $em->getRepository('AppBundle:Data');
	    $files = array();
	    $filesnames = array();
      foreach($types as $type)
      {
        $data = $repository->findOneByFile($type);
        $myfile = fopen($path.$type.".csv", "w") or die("Unable to open file!");
        array_push($files,$path.$type.".csv");
        array_push($filesnames,$type.".csv");
        fwrite($myfile, trim($data->GetData()));
        fclose($myfile);
      }
      // Zip the files
      // Get real path for our folder
      $rootPath = realpath($path);
      // Initialize archive object
      $zip = new ZipArchive();
      $date = new DateTime();
      $zipfile = 'backup('.$date->format('Y-m-d--H-i-s').').zip';
      $zip->open($pathToZip.$zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
      $i = 0;
      foreach ($files as $file)
      {
          $zip->addFile($file, $filesnames[$i]);
          $i++;
      }
      // Zip archive will be created only after closing object
      $zip->close();

      // Return zipped files
      $content = file_get_contents($pathToZip.$zipfile);
      $response = new Response();
      //set headers
      $response->headers->set('Content-Type', 'mime/type');
      $response->headers->set('Content-Disposition', 'attachment;filename="'.$zipfile);
      $response->setContent($content);
      return $response;

    }
    
    /**
     * @Route("/admin/addDate25", name="admin_adddate25")
     */
    public function addDate25(Request $request)
    {
      // Create empty Date
      $em = $this->getDoctrine()->getManager();
	    $repository = $em->getRepository('AppBundle:Data');
      $data = new Data();
      $form = $this->get('form.factory')->create(new DataType(), $data);
      // If for has been send, update empty Date with the formular's data
      if ($form->handleRequest($request)->isValid()) {
        // Update current date
        $addedData = trim($data->GetData());
        $datedata = $repository->findOneByFile("Date");
        $newData = $datedata->GetData();
        $newData = trim($newData);
        $newData = $newData."\n".$addedData;
        $datedata->SetData($newData);
        $em->persist($datedata);
        
        // Update Admin Data
        $admindata = $repository->findOneByFile("Admin");
        $csvadmin = $this->parseCSV(trim($admindata->GetData()), ";", "\n");
        $csvdate = $this->parseCSV($addedData, ";", "\n");
        
        // Get Traceback
        $tracedata = $repository->findOneByFile("Traceback");
        $newtraceData = $tracedata->GetData();
        $newtraceData = trim($newtraceData);
      
        foreach($csvdate as $eda)
        {
          foreach($csvadmin as &$ead)
          {
            if( $eda[1] === $ead[0])
            {
						  $actualmoney = floatval($ead[2]);
						  $toremove = 0.25;
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
      
        return $this->redirect($this->generateUrl('index'));
      }
      return $this->render('AppBundle:Admin:addDate25.html.twig', array('form' => $form->createView()));
    }
    
    
    private function generateRandomUid($data)
    {
      $uid = "";
      do
      {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++)
        {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $uid = $randomString;
      }
      while(strpos($data, $uid ) !== false);
      return $uid;
    }
    
    private function generateRandomPin($data)
    {
      $pin = "";
      do
      {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 5; $i++)
        {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $pin = $randomString;
      }
      while(strpos($data, $pin) !== false);
      return $pin;
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
