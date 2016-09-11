<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 11/9/16
 * Time: 1:51 PM
 */

namespace AppBundle\Job;
use ResqueBundle\Resque\ContainerAwareJob;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RemoteCallJob extends ContainerAwareJob
{
    public function run($args)
    {
        $host = $args['host'];
        $resp_url = $args['resp_url'];

        $client = new Client([
            'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => 200.0,
        ]);



        $url_to_check = "http://api.hackertarget.com/mtr/?q=".$host;
        $user_agent = "Slack/1.0";
        $ch = curl_init($url_to_check);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        $resp = curl_exec($ch);
        curl_close($ch);

        $response = $client->request('POST', $resp_url, [
            'json' => ['text' => $resp]
        ]);
    }
}