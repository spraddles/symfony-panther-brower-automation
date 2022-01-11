<?php

namespace App\Tests;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

require __DIR__.'/../vendor/autoload.php'; // Composer's autoloader

class pantherTest extends PantherTestCase
{
    /** @test */
    public function ExampleTest()
    {

        $client = Client::createChromeClient();
        // Or, if you care about the open web and prefer to use Firefox
        //$client = Client::createFirefoxClient();

        $client = self::createPantherClient(
            [],
            [],
            [
                'chromedriver_arguments' => [
                    '--log-path=myfile.log',
                    '--log-level=DEBUG'
                ],
            ]
        );

        $client->request('GET', '/');

        $client->request('GET', 'https://api-platform.com'); // Yes, this website is 100% written in JavaScript
        $client->clickLink('Get started');

        // Wait for an element to be present in the DOM (even if hidden)
        $crawler = $client->waitFor('#installing-the-framework');
        // Alternatively, wait for an element to be visible
        $crawler = $client->waitForVisibility('#installing-the-framework');

        echo $crawler->filter('#installing-the-framework')->text();

        $client->quit();

        // if error: $client->takeScreenshot('screen.png'); // also dumpout exception error

    }
}