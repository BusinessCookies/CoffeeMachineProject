<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Data;
use AppBundle\Entity\AddMoney;
use AppBundle\Form\AddMoneyType;
use AppBundle\Form\DataType;
DateTime \use;


class AdminController extends Controller
{

	/**
     * @Route("/admin/normalizeData", name="admin_normlizedata")
     */
    public function normalizeData(Request $request)
    {
		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Data');
		$admindata = $repository->findOneByFile("Admin");
		$datedata = $repository->findOneByFile("Date");
		$em = $this->getDoctrine()->getManager();
		$csvadmin = $this->parseCSV($admindata->GetData(), ";", "\n");
		$csvdate = $this->parseCSV($datedata->GetData(), ";", "\n");
		foreach($csvadmin as &$ead)
		{
			if(strtolower($ead[0]) != $ead[0])
			{
				$ead[0] = strtolower($ead[0]);
			  	foreach($csvdate as $eda)
        		{
					if($eda[1] === $ead[0])
            		{
						$actualmoney = floatval($ead[2]);
						$toremove = ($actualmoney<=0)*0.40 + ($actualmoney>0)*0.25;
						$ead[2] = number_format($actualmoney - $toremove,2,'.','');
					}
				}
			}
		}
		$admindata->SetData($this->unparseCSV($csvadmin, ";", "\n"));
		$em->persist($admindata);
		$em->flush();
		return $this->render('AppBundle:Admin:normalizeData.html.twig', array());
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
