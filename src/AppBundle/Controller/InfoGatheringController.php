<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 10/9/16
 * Time: 11:44 AM
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InfoGatheringController extends Controller
{
    /**
     * @Route("/whatweb", name="whatweb")
     */
    public function whatWebAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];

    }

}