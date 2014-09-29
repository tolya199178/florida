#!/bin/bash

# #####################################################################################
# FTP account details
# #####################################################################################


HOST=datatransfer.cj.com  	#This is the FTP servers host or IP address.
USER=3906375             		#This is the FTP user that has access to the server.
PASS=VUr~AenQ          		#This is the password for the FTP user.
REMOTE_DIRECTORY="outgoing/productcatalog/152410"
REMOTE_FILE="Restaurant_com-Product_Catalog.txt.gz"
UNZIPPED_FILE="Restaurant_com-Product_Catalog.txt"

# Call 1. Uses the ftp command with the -inv switches.  -i turns off interactive prompting. -n Restrains FTP from attempting the auto-login feature. -v enables verbose and progress. 

ftp -inv $HOST << EOF
user $USER $PASS
cd $REMOTE_DIRECTORY
type image
get $REMOTE_FILE
bye
EOF

gunzip "$REMOTE_FILE"



# #####################################################################################
# CSV file import
# #####################################################################################

INPUT_FILE=$UNZIPPED_FILE
CURRENT_TIME=$(date "+%Y.%m.%d-%H.%M.%S")

LOG_FILE=/var/www/florida.com/protected/runtime/importbusinesscsv.$CURRENT_TIME.log


./yiic importrestauranttabfile -filename=$INPUT_FILE -overwrite=yes >>"$LOG_FILE" 2>&1

mv $UNZIPPED_FILE $UNZIPPED_FILE.$CURRENT_TIME
