## Prerequisites:
- php 7.3 or greater
- composer
- a paid (non-trial) TradingView account with Pro subscription level

## Config:
- rename the .ENV.EXAMPLE file to just '.ENV'
- set TV_USERNAME in .ENV file (this is your TradingView username, e.g. TV_USERNAME=john.smith@gmail.com)
- set TV_PASSWORD in .ENV file (this is your TradingView password, e.g. TV_PASSWORD=mypassword)
- [OPTIONAL] set PANTHER_NO_HEADLESS (set to 0 for no Chrome UI / run in background as opposed to launching a browser)
- [OPTIONAL] change PANTHER_CHROME_ARGUMENTS to your custom requirements, if you like; you can use any argument so long as ChromeDriver supports it
- add your Pinescript strategy into TradingView & save it (the exact name is important, take note of this for the $strategyName variable) & update this value
- your Pinescript will need to include date range code, if you want them in your CSV
- modify your $strategyName, $exchange, $coins, $dateRanges, $intervals variables in tests/pantherTest.php
- use the $diagnoseTimer variable to diagnose for issues, key issue is Dusk runs too fast, sometimes you need to slow it down (e.g. $testPause=1500, meaning delay each action by 1.5 seconds)

## How to run:
- open a termnial session (in the project directory) and type in the below commands:
- composer require --dev dbrekelmans/bdi
- vendor/bin/bdi detect drivers
- bin/phpunit tests/pantherTest.php

## Output:
- less combinations of coins, dataranges, and intervals will run faster... and vice versa
- a new CSV file (Strategy_XXX.csv) will be created in the root directory
- this file will be overwritten each time the test is run
- a screenshot PNG file will be created (in the root directory) each time there is an error, so you can see where the automation fails