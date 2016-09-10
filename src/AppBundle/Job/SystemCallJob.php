<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 10/9/16
 * Time: 3:09 PM
 */

namespace AppBundle\Job;

use ResqueBundle\Resque\ContainerAwareJob;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SystemCallJob extends ContainerAwareJob
{
    public function run($args)
    {
        $logger = $this->getContainer()->get('logger');
        $logger->addAlert("*****************");
        $host = $args['host'];
        $resp_url = $args['resp_url'];
        $command = $args['command'];
        $command_str = $args['command_string'];

        $client = new Client([
            'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => 200.0,
        ]);

        $process = new Process($command_str);

        try {
            $process->mustRun();

            $resp = $process->getOutput();

        } catch (ProcessFailedException $e) {
            $resp =  $e->getMessage();
        }

        $response = $client->request('POST', $resp_url, [
            'json' => ['text' => $resp]
        ]);


    }
}