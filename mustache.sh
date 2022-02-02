#!/usr/bin/env node

rm -r ./tradingview/output/*

mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_1.pine > ./tradingview/output/Strategy_1.pine
mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_2.pine > ./tradingview/output/Strategy_2.pine
mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_3.pine > ./tradingview/output/Strategy_3.pine
mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_4a.pine > ./tradingview/output/Strategy_4a.pine
mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_5.pine > ./tradingview/output/Strategy_5.pine
mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_6.pine > ./tradingview/output/Strategy_6.pine