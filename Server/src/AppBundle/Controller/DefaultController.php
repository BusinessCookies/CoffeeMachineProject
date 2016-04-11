<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Data;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        // Create needed file if don't exist
        $types = ['Date', 'Admin', 'Traceback', 'Connections'];
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Data');
        foreach($types as $type)
        {
          $data = $repository->findOneByFile($type);
          if($data == null)
          {
            $data = new Data();
            $data->SetData('');
            $data->SetFile($type);
            $em->persist($data);
            $em->flush();
          }
        }
        // Return homepage
        return $this->render('AppBundle:Index:index.html.twig');
    }
}
