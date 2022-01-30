#!/usr/bin/env node

for file in src/views/*.pine
do
	for ((i = 0; i < 3; i++))
	do
        mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_1.pine > ./tradingview/Strategy_1.pine
	done
done