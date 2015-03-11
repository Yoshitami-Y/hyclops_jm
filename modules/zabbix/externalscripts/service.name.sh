#!/bin/bash

FILE=SystemMonitorNotification_zabbix.xml
DIR=/usr/lib/zabbix/externalscripts/
FILE_NAME=${DIR}${FILE}
i=0

while read line
do
	NAME=`echo "${line}" | grep service_name_on* | awk '{ print $2 }' | cut -d"\"" -f2 | cut -d"\"" -f1`
	if [ -n "$NAME" ]
	then
		ARRAY[$i]=$NAME
		i=`expr $i+1`
	fi

done < $FILE_NAME


n=${#ARRAY[@]}
n=$((n - 1))
FIRST=1

echo "{"
echo "  \"data\":["

while [ $n -ge 0 ];
do
	
	echo -e -n "\t\t{ \"{#SERVICE_NAME}\":\"${ARRAY[$n]}\"}"
	if [ ${n} -eq 0 ]
	then
		echo ""
		
	else
		echo ","
	fi
	n=$((n - 1))
done

	echo "  ]"
	echo "}"

#

