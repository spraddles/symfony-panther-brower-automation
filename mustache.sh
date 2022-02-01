#!/usr/bin/env node

rm -r ./tradingview/output/*

count=$(ls ./tradingview/scripts | wc -l)+1

for file in src/views/*.pine
do
	for ((i = 1; i < count; i++))
	do
        mustache ./tradingview/templates/source.json ./tradingview/scripts/Strategy_$i.pine > ./tradingview/output/Strategy_$i.pine
	done
done