#!/bin/bash


# #####################################################################################
# CSV file import
# #####################################################################################

INPUT_FILE=/home/pradesh/Workspace/Projects/florida.com/phase2/databases/import/maxmind_cities/maxmind-florida-cities.csv 

CURRENT_TIME=$(date "+%Y.%m.%d-%H.%M.%S")

LOG_FILE=/var/www/florida.com/protected/runtime/import_maxmind_cities.$CURRENT_TIME.log

./yiic importcitylist "$INPUT_FILE" >>"$LOG_FILE" 2>&1

