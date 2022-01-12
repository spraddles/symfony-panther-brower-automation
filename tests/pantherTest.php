<?php

// ref: https://www.lambdatest.com/blog/implicit-explicit-wait-in-selenium

namespace App\Tests;

use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverNavigation;

use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

require __DIR__.'/../vendor/autoload.php';

class pantherTest extends PantherTestCase
{
    /** @test */
    public function ExampleTest()
    {

        $exchanges = [
            'binance'
        ];

        // login
        $website = 'https://www.tradingview.com/';
        $userArea = '.tv-header__user-menu-button.tv-header__user-menu-button--anonymous.js-header-user-menu-button';
        $signInLink = 'div[class^="item-"][data-name="header-user-menu-sign-in"]';
        $emailLink = '.tv-signin-dialog__social.tv-signin-dialog__toggle-email.js-show-email';
        $focusUser = '.tv-signin-dialog input[id^="email-signin__user-name-input__"]';
        $focusPassword = '.tv-signin-dialog input[id^="email-signin__password-input__"]';
        $username = $_ENV['TV_USERNAME'];
        $password = $_ENV['TV_PASSWORD'];
        $signInButton = '.tv-signin-dialog__footer button[id^="email-signin__submit-button__"]';
        $chartLink = 'a[data-main-menu-root-track-id="chart"]';

        // coins
        $coins = [
            'ETH/BTC',
            'MATIC/BTC',
            'XRP/BTC',
            'LUNA/BTC',
            'BNB/BTC',
            'SOL/BTC',
            'EOS/BTC',
            'ADA/BTC',
            'LTC/BTC',
            'TRX/BTC',
            'DOT/BTC',
            'WAXP/BTC',
            'BCH/BTC',
            'XTZ/BTC',
            'MATIC/ETH',
            'XRP/ETH',
            'LUNA/ETH',
            'BNB/ETH',
            'SOL/ETH',
            'EOS/ETH',
            'ADA/ETH',
            'LTC/ETH',
            'TRX/ETH',
            'DOT/ETH',
            'MATIC/BNB',
            'XRP/BNB',
            'TRX/XRP',
            'LUNA/BNB',
            'SOL/BNB',
            'EOS/BNB',
            'ADA/BNB',
            'LTC/BNB',
            'TRX/BNB',
            'DOT/BNB',
            'WAXP/BNB',
            'BCH/BNB',
            'XTZ/BNB'
        ];

        // coins & exchanges
        $exchange = 'Binance';
        $coinList = '#header-toolbar-symbol-search';
        $exchangeButton = '[data-name="symbol-search-items-dialog"] .apply-common-tooltip';
        $exchangeInput = '[data-outside-boundary-for="exchanges-search"] input';
        $exchangeName = '[data-outside-boundary-for="exchanges-search"] [data-name="exchanges-search"] div[class^="exchangeItemsContainer-"] div[class^="wrap-"]:first-of-type';
        $coinInput = '#overlap-manager-root [data-dialog-name="Symbol Search"] div[class^="container-"] input ';
        $coinOption = '[data-dialog-name="Symbol Search"] div[class^="listContainer-"] div[class^="itemRow-"]:nth-of-type(2)';
        $cookieButton = '[data-role="toast-container"] div[class^="toast-wrapper-"] div[class^="actions-"] button';

        // clear chart
        $arrowOption = '[data-name="removeAllDrawingTools"] div[class^="arrow-"]';
        $removeAll = '#overlap-manager-root div[class^="menuBox-"] [data-name="remove-all"]';

        // pinescript
        $bottomAreaPane = '#bottom-area';
        $pineScriptTab = '#footer-chart-panel div[class^="tabs-"] div[class^="tab-"]:nth-of-type(3)';
        $openScriptMenu = '#bottom-area .bottom-widgetbar-content.scripteditor.tv-script-widget div[class^="rightControlsBlock-"] div[data-name="open-script"]';
        $openMyScript = '#overlap-manager-root div[class^="menuBox-"] div[class^="item-"]:first-of-type';
        $strategySearchInput = '#overlap-manager-root div[class^="container-"]:nth-of-type(2) div[class^="inputContainer-"] input';
        $strategyName = 'Strategy_1';
        $strategySelect = '#overlap-manager-root div[class^="wrapper-"] div[class^="container-"] div[class^="list-"] div[class^="itemRow-"]';
        $closeStrategySearch = 'div[data-outside-boundary-for="open-user-script-dialog"] div[class^="wrapper-"] div[class^="container-"]:first-of-type span[class^="close-"]';
        $addToChart = '#bottom-area .bottom-widgetbar-content.scripteditor.tv-script-widget #tv-script-pine-editor-header-root div[class^="content-"] div[class^="rightControlsBlock-"] div[data-name="add-script-to-chart"]';
        $performanceSummaryTab = '.layout__area--bottom #bottom-area .bottom-widgetbar-content.backtesting .backtesting-head-wrapper .backtesting-select-wrapper ul.report-tabs li:nth-of-type(2)';
        $performanceSummaryActive = '.layout__area--bottom #bottom-area .bottom-widgetbar-content.backtesting .backtesting-head-wrapper .backtesting-select-wrapper ul.report-tabs li.active:nth-of-type(2)';

        // date ranges: the 3rd item in array is days in that period (used for trades p/day calculation)
        $dateRanges = [
            /*['div[id$="_item_All-2021"]', 'All 2021', 298],
            ['div[id$="_item_32-weeks"]', '32 weeks', 224],
            ['div[id$="_item_16-weeks"]', '16 weeks', 112],
            ['div[id$="_item_8-weeks"]', '8 weeks', 56],
            ['div[id$="_item_3-weeks"]', '3 weeks', 21],*/
            ['div[id$="_item_Bad-period-BTC"]', 'Bad period BTC', 99]
        ];

        // chart setting
        $chartSettings = '#bottom-area .bottom-widgetbar-content.backtesting .group:nth-of-type(2) .js-backtesting-open-format-dialog';
        $inputsTab = '#overlap-manager-root div[data-outside-boundary-for="indicator-properties-dialog"] div[class^="scrollWrap-"] div[class^="tabs-"] [data-value="inputs"]';
        $selectArrow = '#overlap-manager-root div[data-outside-boundary-for="indicator-properties-dialog"] div[class^="scrollable-"] div[class^="content-"] div[class^="cell-"]:last-of-type span[class^="container-"] span[class^="inner-slot-"]:nth-of-type(2)';
        $okButton = '#overlap-manager-root div[data-outside-boundary-for="indicator-properties-dialog"] div[class^="footer-"] div[class^="buttons-"] span[class^="submitButton-"] button';

        // time intervals
        $intervals = [
            ['#overlap-manager-root [data-value="1M"]', '1 Month'],
            ['#overlap-manager-root [data-value="1W"]', '1 Week'],
            ['#overlap-manager-root [data-value="1D"]', '1 Day'],
            ['#overlap-manager-root [data-value="240"]', '4 hrs'],
            ['#overlap-manager-root [data-value="180"]', '3 hrs'],
            ['#overlap-manager-root [data-value="120"]', '2 hrs'],
            ['#overlap-manager-root [data-value="60"]', '1 hr'],
            ['#overlap-manager-root [data-value="45"]', '45 mins'],
            ['#overlap-manager-root [data-value="30"]', '30 mins'],
            ['#overlap-manager-root [data-value="15"]', '15 mins'],
            ['#overlap-manager-root [data-value="5"]', '5 mins']
        ];
        $intervalMenu = '#header-toolbar-intervals > div[class^="menu-"]';

        // data points
        $netProfit = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(2) > div:nth-child(2) > span';
        $buyAndHold = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(5) > td:nth-child(2) > div:nth-child(2) > span';
        $TotalTradesClosed = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(12) > td:nth-child(2)';
        $TotalTradesOpen = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(13) > td:nth-child(2)';
        $winningTrades = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(14) > td:nth-child(2)';
        $losingTrades = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(15) > td:nth-child(2)';
        $percentProfitable = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(16) > td:nth-child(2)';
        $winLossRatio = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(20) > td:nth-child(2)';
        $sharpeRatio = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(6) > td:nth-child(2)';
        $sortinoRatio = '#bottom-area > div.bottom-widgetbar-content.backtesting > div.backtesting-content-wrapper > div > div > div > table > tbody > tr:nth-child(7) > td:nth-child(2)';

        // CSV file
        $csvHeaders = array('Coin','Exchange','Date range','Interval','Net profit','B+H','Difference','Trades p/day','Total Trades closed','Trades open','Winning trades','Losing trades','Percent profitable','Win loss ratio','Sharpe Ratio','Sortino Ratio');

        /* * * * * * * * * * * */
        /* INITIALIZE
        /* * * * * * * * * * * */

        $converter = new CssSelectorConverter();
        $client = self::createPantherClient(
            [],
            [],
            [
                'chromedriver_arguments' => [
                    '--log-path=myfile.log',
                    '--log-level=DEBUG',
                    '--window-size=1920,1080',
                    '--headless'
                ]
            ]
        );

        
        // sign in
        $client->request('GET', $website);

        $client->waitForVisibility( $userArea );
        $client->executeScript("document.querySelector('".$userArea."').click()");

        $client->waitForVisibility( $signInLink );
        $client->executeScript("document.querySelector('".$signInLink."').click()");

        $client->waitForVisibility( $emailLink );
        $client->executeScript("document.querySelector('".$emailLink."').click()");

        $client->waitForVisibility( $focusUser );
        $client->executeScript("document.querySelector('".$focusUser."').click()");
        $client->findElement(WebDriverBy::cssSelector( $focusUser ))->sendKeys( $username );

        $client->waitForVisibility( $focusPassword );
        $client->executeScript("document.querySelector('".$focusPassword."').click()");
        $client->findElement(WebDriverBy::cssSelector( $focusPassword ))->sendKeys( $password );

        $client->waitForVisibility( $signInButton );
        $client->executeScript("document.querySelector('".$signInButton."').click()");

        sleep(2);

        $client->waitForVisibility( $chartLink );
        $client->executeScript("document.querySelector('".$chartLink."').click()");

        $client->waitForVisibility( $cookieButton );
        $client->executeScript("document.querySelector('".$cookieButton."').click()");   
        

        // clear chart
        for ($retryAttempts = 0; $retryAttempts < 4; $retryAttempts++) {
            try {
                $client->executeScript("document.querySelector('".$arrowOption."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($retryAttempts < 4) { sleep(2); }
                else { throw($e); }
            }
        }





        


        $client->executeScript("document.querySelector('".$removeAll."').click()");


        // open pinescript tab (if its closed)
        $element = $client->findElement(WebDriverBy::cssSelector( $bottomAreaPane ));
        $bottomAreaPaneHeight = $element->getAttribute('style');
        if ($bottomAreaPaneHeight = 'height: 0px;') { 

            $client->waitForVisibility( $pineScriptTab );
            $client->executeScript("document.querySelector('".$pineScriptTab."').click()");
            
            $client->waitForVisibility( $openScriptMenu );
            $client->executeScript("document.querySelector('".$openScriptMenu."').click()");
        }


        // strategy
        //$client->waitForVisibility( $openScriptMenu );
        sleep(1);
        $client->executeScript("document.querySelector('".$openScriptMenu."').click()");

        //$client->waitForVisibility( $openMyScript );
        sleep(5);
        $client->executeScript("document.querySelector('".$openMyScript."').click()");

        //$client->waitForVisibility( $strategySearchInput );
        sleep(1);
        $client->findElement(WebDriverBy::cssSelector( $strategySearchInput ))->sendKeys( $strategyName );

        //$client->waitForVisibility( $strategySelect );
        sleep(1);
        $client->executeScript("document.querySelector('".$strategySelect."').click()");

        //$client->waitForVisibility( $closeStrategySearch );
        sleep(1);
        $client->executeScript("document.querySelector('".$closeStrategySearch."').click()");

        //$client->waitForVisibility( $addToChart );
        sleep(1);
        $client->executeScript("document.querySelector('".$addToChart."').click()");



        









        $client->quit();
        // if error: $crawler = $client->takeScreenshot('screen.png'); // also dumpout exception error

    }
}