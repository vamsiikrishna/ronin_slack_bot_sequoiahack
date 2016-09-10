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
    public function WhatWebAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];

    }

    /**
     * @Route("/sslyze", name="sslyze")
     */
    public function SslYzeAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];

    }

    /**
     * @Route("/dnsrecon", name="dnsrecon")
     */
    public function DnsReconAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];
    }

    /**
     * @Route("/wafwoof", name="wafwoof")
     */
    public function WafWoofAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];
    }

    /**
     * @Route("lbd", name="lbd")
     */
    public function LbdAction(Request $request)
    {
        $data = $request->request->all();
        $host = $data['text'];
    }





}