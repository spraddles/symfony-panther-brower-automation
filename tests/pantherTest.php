<?php

// ref: https://www.lambdatest.com/blog/implicit-explicit-wait-in-selenium

namespace App\Tests;

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

        /* VARIABLES * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


        // exchange
        $exchange = 'Binance';

        // strategies
        $strategies = [
            'Strategy_2',
            'Strategy_6',
        ];

        // coins
        $coins = [

            // USDT pairs
            'BTCUSDT',
            'ETHUSDT',
            'BNBUSDT',
            'SOLUSDT',
            'ADAUSDT',
            'XRPUSDT',
            'DOTUSDT',
            'MATICUSDT',
            'LUNAUSDT',
            'LTCUSDT',
            'TRXUSDT',
            'BCHUSDT',
            'XTZUSDT',
            'EOSUSDT',
            'WAXPUSDT'

            // other pairs
            /*'ETHBTC',
            'MATICBTC',
            'XRPBTC',
            'LUNABTC',
            'BNBBTC',
            'SOLBTC',
            'EOSBTC',
            'ADABTC',
            'LTCBTC',
            'TRXBTC',
            'DOTBTC',
            'WAXPBTC',
            'BCHBTC',
            'XTZBTC',
            'MATICETH',
            'XRPETH',
            'LUNAETH',
            'BNBETH',
            'SOLETH',
            'EOSETH',
            'ADAETH',
            'LTCETH',
            'TRXETH',
            'DOTETH',
            'MATICBNB',
            'XRPBNB',
            'TRXXRP',
            'LUNABNB',
            'SOLBNB',
            'EOSBNB',
            'ADABNB',
            'LTCBNB',
            'TRXBNB',
            'DOTBNB',
            'WAXPBNB',
            'BCHBNB',
            'XTZBNB'*/
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

        // coins & exchanges
        $coinList = '#header-toolbar-symbol-search';
        $exchangeButton = '[data-name="symbol-search-items-dialog"] .apply-common-tooltip';
        $exchangeInput = '[data-outside-boundary-for="exchanges-search"] input';
        $exchangeName = '[data-outside-boundary-for="exchanges-search"] [data-name="exchanges-search"] div[class^="exchangeItemsContainer-"] div[class^="wrap-"]:first-of-type';
        $coinInput = '#overlap-manager-root [data-dialog-name="Symbol Search"] div[class^="container-"] input ';
        $coinSelect = '[data-dialog-name="Symbol Search"] div[class^="listContainer-"] div[class^="itemRow-"]:nth-of-type(2)';
        $cookieButton = '[data-role="toast-container"] div[class^="toast-wrapper-"] div[class^="actions-"] button';

        // clear chart
        $arrowOption = '[data-name="removeAllDrawingTools"] div[class^="arrow-"]';
        $removeAll = '#overlap-manager-root div[class^="menuBox-"] [data-name="remove-all"]';

        // pinescript
        $bottomAreaPane = '#bottom-area';
        $pineScriptTab = '#footer-chart-panel div[class^="tabs-"] div[class^="tab-"]:nth-of-type(3) div[class^="title-"]';
        $strategyTesterTab = '#footer-chart-panel div[class^="tabs-"] div[class^="tab-"]:nth-of-type(4) div[class*=" active-"]';
        $openScriptMenu = '#bottom-area .bottom-widgetbar-content.scripteditor.tv-script-widget div[class^="rightControlsBlock-"] div[data-name="open-script"]';
        $xpathMyScript = '//div[contains(text(),"My script…")]';
        $strategySearchInput = '#overlap-manager-root div[class^="container-"]:nth-of-type(2) div[class^="inputContainer-"] input';
        $strategySelect = '#overlap-manager-root div[class^="dialog-"] div[class^="wrapper-"] div[class^="container-"]:nth-of-type(4) div[class^="list-"] div[class^="itemRow-"] div[class*="itemInfo-"]';
        $closeStrategySearch = 'div[data-outside-boundary-for="open-user-script-dialog"] div[class^="wrapper-"] div[class^="container-"]:first-of-type span[class^="close-"]';
        $addToChart = '#bottom-area .bottom-widgetbar-content.scripteditor.tv-script-widget #tv-script-pine-editor-header-root div[class^="content-"] div[class^="rightControlsBlock-"] div[data-name="add-script-to-chart"]';
        $performanceSummaryTab = '.layout__area--bottom #bottom-area .bottom-widgetbar-content.backtesting .backtesting-head-wrapper .backtesting-select-wrapper ul.report-tabs li:nth-of-type(2)';
        $performanceSummaryActive = '.layout__area--bottom #bottom-area .bottom-widgetbar-content.backtesting .backtesting-head-wrapper .backtesting-select-wrapper ul.report-tabs li.active:nth-of-type(2)';

        // date ranges: the 3rd item in array is days in that period (used for trades p/day calculation)
        $dateRanges = [
            ['div[id$="_item_All-2021"]', 'All 2021', 298],
            ['div[id$="_item_32-weeks"]', '32 weeks', 224],
            ['div[id$="_item_16-weeks"]', '16 weeks', 112],
            ['div[id$="_item_8-weeks"]', '8 weeks', 56],
            ['div[id$="_item_3-weeks"]', '3 weeks', 21],
            ['div[id$="_item_Bad-period-BTC"]', 'Bad period BTC', 99]
        ];

        // chart setting
        $chartSettings = '#bottom-area .bottom-widgetbar-content.backtesting .group:nth-of-type(2) .js-backtesting-open-format-dialog';
        $inputsTab = '#overlap-manager-root div[data-outside-boundary-for="indicator-properties-dialog"] div[class^="scrollWrap-"] div[class^="tabs-"] [data-value="inputs"]';
        $selectArrow = '#overlap-manager-root div[data-outside-boundary-for="indicator-properties-dialog"] div[class^="scrollable-"] div[class^="content-"] div[class^="cell-"]:nth-of-type(2) span[class^="container-"] span[class^="inner-slot-"]:nth-of-type(2)';
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

        // Other
        $diagnoseTimer = 0;
        $retryAttempts = 4; // actually 4 = 5 as it starts from 0 not 1
        $retrySleep = 4;


        /* INITIALIZE * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        $client = self::createPantherClient(
            [],
            [],
            []
        );

        /* START PROCESS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

        
        // sign in
        $client->request('GET', $website);
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$userArea."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$signInLink."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$emailLink."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$focusUser."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->findElement(WebDriverBy::cssSelector( $focusUser ))->sendKeys( $username );
                break;
            }
            catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$focusPassword."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->findElement(WebDriverBy::cssSelector( $focusPassword ))->sendKeys( $password );
                break;
            }
            catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$signInButton."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        sleep(2);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$chartLink."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);

        for ($i = 0; true; $i++) {
            try {
                $client->executeScript("document.querySelector('".$cookieButton."').click()");
                break;
            }
            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                if ($i < $retryAttempts) { 
                    sleep($retrySleep); 
                }
                else { 
                    echo '"Retry error: #' . $i .'"';
                    $client->takeScreenshot('screenshot.png');
                    throw($e);
                }
            }
        }
        sleep($diagnoseTimer);


        // loop through strategies
        foreach ($strategies as $strategy) {

        
            // clear chart
            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.querySelector('".$arrowOption."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.querySelector('".$removeAll."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);


            // open pinescript tab: if its minimized
            for ($i = 0; true; $i++) {
                try {
                    $element = $client->findElement(WebDriverBy::cssSelector( $bottomAreaPane ));
                    $bottomAreaPaneHeight = $element->getAttribute('style');
                    break;
                }
                catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            if ($bottomAreaPaneHeight = 'height: 0px;') {
                sleep(1);
                for ($i = 0; true; $i++) {
                    try {
                        $client->executeScript("document.querySelector('".$pineScriptTab."').click()");
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);
            }


            // select pinescript tab: if other tab is active
            for ($i = 0; true; $i++) {
                try {
                    if (count($client->findElements(WebDriverBy::cssSelector( $strategyTesterTab ))) !== 0) {
                        $client->executeScript("document.querySelector('".$pineScriptTab."').click()");
                    };
                    break;
                }
                catch (\Facebook\WebDriver\Exception\NoSuchElementException | \Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);


            // strategy
            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.querySelector('".$openScriptMenu."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep);
                        continue;
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.evaluate('".$xpathMyScript."', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null ).singleNodeValue.click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            for ($i = 0; true; $i++) {
                try {
                    $client->findElement(WebDriverBy::cssSelector( $strategySearchInput ))->sendKeys( $strategy );
                    break;
                }
                catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            for ($i = 0; true; $i++) {
                try {
                    sleep(1);
                    $client->executeScript("document.querySelector('".$strategySelect."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.querySelector('".$closeStrategySearch."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            sleep(2);

            for ($i = 0; true; $i++) {
                try {
                    $client->executeScript("document.querySelector('".$addToChart."').click()");
                    break;
                }
                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                    if ($i < $retryAttempts) { 
                        sleep($retrySleep); 
                    }
                    else { 
                        echo '"Retry error: #' . $i .'"';
                        $client->takeScreenshot('screenshot.png');
                        throw($e);
                    }
                }
            }
            sleep($diagnoseTimer);

            
            // prepare CSV file
            $CSVfilename = $strategy.'.csv';
            $file = fopen( $CSVfilename, 'w' );
            if ($file === false) {
                die('Error opening the file ' . $CSVfilename);
            };
            fputcsv( $file, $csvHeaders );


            // loop through coins
            foreach ($coins as $coin) { 
                

                // choose exchange
                for ($i = 0; true; $i++) {
                    try {
                        $client->executeScript("document.querySelector('".$coinList."').click()");
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);

                for ($i = 0; true; $i++) {
                    try {
                        $client->executeScript("document.querySelector('".$exchangeButton."').click()");
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);

                for ($i = 0; true; $i++) {
                    try {
                        $client->findElement(WebDriverBy::cssSelector( $exchangeInput ))->sendKeys( $exchange );
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);

                for ($i = 0; true; $i++) {
                    try {
                        $client->executeScript("document.querySelector('".$exchangeName."').click()");
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);


                // choose coin
                for ($i = 0; true; $i++) {
                    try {
                        $client->findElement(WebDriverBy::cssSelector( $coinInput ))->clear();
                        $client->findElement(WebDriverBy::cssSelector( $coinInput ))->sendKeys( $coin );
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\NoSuchElementException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);

                for ($i = 0; true; $i++) {
                    try {
                        $client->executeScript("document.querySelector('".$coinSelect."').click()");
                        break;
                    }
                    catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                        if ($i < $retryAttempts) { 
                            sleep($retrySleep); 
                        }
                        else { 
                            echo '"Retry error: #' . $i .'"';
                            $client->takeScreenshot('screenshot.png');
                            throw($e);
                        }
                    }
                }
                sleep($diagnoseTimer);

                
                // date ranges loop
                foreach ($dateRanges as $dateRange) {


                    // check if 'Strategy Tester' tab not open
                    for ($i = 0; true; $i++) {
                        try {
                            if (!$client->findElement(WebDriverBy::cssSelector( $strategyTesterTab ))) {
                                // open 'Strategy Tester' tab
                                $client->executeScript("document.querySelector('".$strategyTesterTab."').click()");
                            }
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException | \Facebook\WebDriver\Exception\NoSuchElementException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);

                    // change date range
                    for ($i = 0; true; $i++) {
                        try {
                            $client->executeScript("document.querySelector('".$chartSettings."').click()");
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);

                    for ($i = 0; true; $i++) {
                        try {
                            $client->executeScript("document.querySelector('".$inputsTab."').click()");
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);

                    for ($i = 0; true; $i++) {
                        try {
                            $client->executeScript("document.querySelector('".$selectArrow."').click()");
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException | \Facebook\WebDriver\Exception\StaleElementReferenceException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);

                    for ($i = 0; true; $i++) {
                        try {
                            $client->executeScript("document.querySelector('".$dateRange[0]."').click()");
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);

                    for ($i = 0; true; $i++) {
                        try {
                            $client->executeScript("document.querySelector('".$okButton."').click()");
                            sleep(1);
                            break;
                        }
                        catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                            if ($i < $retryAttempts) { 
                                sleep($retrySleep); 
                            }
                            else { 
                                echo '"Retry error: #' . $i .'"';
                                $client->takeScreenshot('screenshot.png');
                                throw($e);
                            }
                        }
                    }
                    sleep($diagnoseTimer);


                    // intervals loop
                    foreach ($intervals as $interval) {


                        // change time interval
                        for ($i = 0; true; $i++) {
                            try {
                                $client->executeScript("document.querySelector('".$intervalMenu."').click()");
                                break;
                            }
                            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $client->executeScript("document.querySelector('".$interval[0]."').click()");
                                break;
                            }
                            catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);


                        // make sure 'performance summary' pane is open
                        if (!$client->findElement(WebDriverBy::cssSelector( $performanceSummaryActive ))) {
                            for ($i = 0; true; $i++) {
                                try {
                                    $client->executeScript("document.querySelector('".$performanceSummaryTab."').click()");
                                    break;
                                }
                                catch (\Facebook\WebDriver\Exception\JavascriptErrorException $e) {
                                    if ($i < $retryAttempts) { 
                                        sleep($retrySleep); 
                                    }
                                    else { 
                                        echo '"Retry error: #' . $i .'"';
                                        $client->takeScreenshot('screenshot.png');
                                        throw($e);
                                    }
                                }
                            }
                            sleep($diagnoseTimer);
                        }

                        sleep(3);

                        // data points
                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $netProfit ));
                                $netProfitData = strstr( $element->getText(), ' %', true );
                                break;
                            }
                            catch (
                                    \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                    \Facebook\WebDriver\Exception\NoSuchElementException |
                                    \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                    \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $buyAndHold ));
                                $buyAndHoldData = strstr( $element->getText(), ' %', true );
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        $difference = NULL;
                        $difference = (int)$netProfitData - (int)$buyAndHoldData;

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $TotalTradesClosed ));
                                $TotalTradesClosedData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);
                        
                        if( ( ((int)$TotalTradesClosedData !== 0))  || ((int)$dateRange[2] !== 0) ) {
                            $tradesPerDay = number_format( (int)$TotalTradesClosedData / (int)$dateRange[2], 2 );
                        }
                        else $tradesPerDay = 0;

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $TotalTradesOpen ));
                                $TotalTradesOpenData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $winningTrades ));
                                $winningTradesData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $losingTrades ));
                                $losingTradesData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $percentProfitable ));
                                $percentProfitableData = strstr( $element->getText(), ' %', true );
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $winLossRatio ));
                                $winLossRatioData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $sharpeRatio ));
                                $sharpeRatioData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);

                        for ($i = 0; true; $i++) {
                            try {
                                $element = NULL;
                                $element = $client->findElement(WebDriverBy::cssSelector( $sortinoRatio ));
                                $sortinoRatioData = $element->getText();
                                break;
                            }
                            catch (
                                \Facebook\WebDriver\Exception\StaleElementReferenceException | 
                                \Facebook\WebDriver\Exception\NoSuchElementException |
                                \Facebook\WebDriver\Exception\UnrecognizedExceptionException |
                                \Facebook\WebDriver\Exception\NoSuchWindowException $e) {
                                if ($i < $retryAttempts) { 
                                    sleep($retrySleep); 
                                }
                                else { 
                                    echo '"Retry error: #' . $i .'"';
                                    $client->takeScreenshot('screenshot.png');
                                    throw($e);
                                }
                            }
                        }
                        sleep($diagnoseTimer);


                        // CSV add data
                        $lines = [
                            $coin,
                            $exchange,
                            $dateRange[1],
                            $interval[1],
                            $netProfitData,
                            $buyAndHoldData,
                            $difference,
                            $tradesPerDay,
                            $TotalTradesClosedData,
                            $TotalTradesOpenData,
                            $winningTradesData,
                            $losingTradesData,
                            $percentProfitableData,
                            $winLossRatioData,
                            $sharpeRatioData,
                            $sortinoRatioData
                        ];
                        fputcsv( $file, $lines );
                    }
                }
            }
        }
        $client->quit();
    }
}