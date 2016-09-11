<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 11/9/16
 * Time: 12:10 PM
 */

namespace AppBundle\Job;

use ResqueBundle\Resque\ContainerAwareJob;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DomainScanJob extends ContainerAwareJob
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

        $process = new Process("cd /root/tools/domain-scan && docker-compose run scan $host --scan=inspect && mv results/inspect.csv /var/www/ronin_slack_bot_sequoiahack/web/op/results");

        try {
            $process->mustRun();

            $resp = $process->getOutput();

        } catch (ProcessFailedException $e) {
            $resp =  $e->getMessage();
        }

        $response = $client->request('POST', $resp_url, [
            'json' => [
                'text' => "Scanning Done !!! \n Please Download the report from the URL below \n
                https://slack.roninbot.com/op/results/inspect.csv
                ",
            ]
        ]);

    }
}