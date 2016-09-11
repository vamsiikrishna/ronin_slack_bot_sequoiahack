<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 10/9/16
 * Time: 11:44 AM
 */

namespace AppBundle\Controller;
use AppBundle\Job\SystemCallJob;
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
        $data = $request->request->all();
        $host = $data['text'];
        $resp_url = $data['response_url'];
        $resque = $this->get('resque');

        $command = 'whatweb';

        $command_str = "$command $host --colour=never | tr ',' '\n'";


        $job = new SystemCallJob();
        $job->args = array(
            'host'    => $host,
            'resp_url' => $resp_url,
            'command' => $command,
            'command_string' => $command_str
        );
        $resque->enqueue($job);

        $response = new Response("Will respond back with your results shortly....");
        return $response;

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

    /**
     * @Route("/nping")
     */
    public function NpingAction(Request $request)
    {
        $data = $request->request->all();

        $data = $request->request->all();
        $host = $data['text'];
        $resp_url = $data['response_url'];
        $resque = $this->get('resque');

        $command = 'nping';

        $command_str = "$command $host";


        $job = new SystemCallJob();
        $job->args = array(
            'host'    => $host,
            'resp_url' => $resp_url,
            'command' => $command,
            'command_string' => $command_str
        );
        $resque->enqueue($job);

        $response = new Response("Will respond back with your results shortly....");
        return $response;

    }

    /**
     * @param Request $request
     * @Route("/tool")
     */
    public function ToolAction(Request $request)
    {
        $data = $request->request->all();

        $data = $request->request->all();
        $host = $data['text'];
        $command = ltrim($data['command'],'/');




        switch ($command) {
            case 'dnslookup' :
                $uri = 'dnslookup';
                break;
            case 'reversedns':
                $uri = 'reversedns';
                break;
            case 'hostsearch' :
                $uri = 'hostsearch';
                break;
            case  'findshareddns':
                $uri = 'findshareddns';
                break;
            case 'zonetransfer':
                $uri = 'zonetransfer';
                break;
            case 'whois':
                $uri = 'whois';
                break;
            default;
                $uri = null;
                break;
        }

        $url_to_check = "http://api.hackertarget.com/$uri/?q=".$host;
        $user_agent = "Slack/1.0";
        $ch = curl_init($url_to_check);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        $resp = curl_exec($ch);
        curl_close($ch);

        return new Response($resp);

    }





}