#!/usr/bin/php

<?php

#$NAME=`echo $argv[3] | tr -d ' ' | cut -d':' -f 2`;
$NAME=`echo $argv[3] | cut -d' ' -f5-`;
$NAME=`echo "$NAME" | tr -d '\n'`;

#echo $NAME;

  // 送信データ
$post=<<<EOF
<?xml version="1.0" encoding="ISO-8859-1"?>

<add_order  job_chain   ="sos/notification/ResetNotifications"
            id          ="acknowledgement"
            title       ="acknowledgement">
    <params>
        <param name="hibernate_configuration_file"  value="config/hibernate.cfg.xml" />
        <param name="service_name"  value="$NAME"/>
        <param name="system_id"     value="zabbix"/>
        <param name="operation"     value="acknowledge" />
     </params>
</add_order>
EOF;

  // SOAPメッセージ送信(POST)
  $ch=curl_init();
  curl_setopt ($ch,CURLOPT_URL,"http://localhost:4444/scheduler");
  curl_setopt ($ch,CURLOPT_POST,true);
  curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
  curl_setopt ($ch,CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/soap+xml;charset=UTF-8'));
  $res = curl_exec($ch);
  curl_close ($ch);

  // 応答データ
  echo $res;
?>
