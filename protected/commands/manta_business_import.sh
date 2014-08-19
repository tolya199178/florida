#!/bin/bash


# #####################################################################################
# CSV file import
# #####################################################################################

INPUT_FILE=/home/pradesh/Workspace/Projects/florida.com/phase2/databases/import/manta/manta_business_import.txt
CURRENT_TIME=$(date "+%Y.%m.%d-%H.%M.%S")

LOG_FILE=/var/www/florida.com/protected/runtime/importbusinesscsv.$CURRENT_TIME.log

# ./yiic importbusinesscsv "$INPUT_FILE" >>"$LOG_FILE" 2>&1

# #####################################################################################
# import table to business and category sync
# #####################################################################################

CURRENT_TIME=$(date "+%Y.%m.%d-%H.%M.%S")

LOG_FILE=/var/www/florida.com/protected/runtime/syncmantaimportswithbiztable.$CURRENT_TIME.log

./yiic syncmantaimportswithbiztable >>"$LOG_FILE" 2>&1
