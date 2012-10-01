<?php

$fp = @fsockopen("10.1.99.149", 389,$err,$err1,2);
if ($fp) {
   $x=1;
	fclose($fp);}
	echo $x;


session_start(); //Start Session Variable
$LDAPHost = "ldap://10.1.99.149:389";       //Your LDAP server DNS Name or IP Address
$slave = "ldap://10.1.99.72:389";

  $_SESSION['dn'] = "dc=ust,dc=edu,dc=ph"; //Put your Base DN here
  $dn=$_SESSION['dn'];
  $LDAPUserDomain = "@ust.edu.ph";  //Needs the @, but not always the same as the LDAP server domain
  $LDAPUser = "cn=root,";        //A valid Active Directory login
  $LDAPUserPassword = "miko1023";

  
   if($x==1){
  
   $_SESSION['cnx'] = ldap_connect($LDAPHost) or die("Could not connect to LDAP");
   $cnx = $_SESSION['cnx'];

  
  ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);  //Set the LDAP Protocol used by your AD service
  ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);         //This was necessary for my AD to do anything
 ldap_bind($cnx,$LDAPUser.$dn,$LDAPUserPassword) or die("Could not bind to LDAP");
  
  }
  else{
  
 $_SESSION['cnx'] = ldap_connect($slave) or die("Could not connect to LDAP");
   $cnx = $_SESSION['cnx'];

  
  ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);  //Set the LDAP Protocol used by your AD service
  ldap_set_option($cnx, LDAP_OPT_REFERRALS, 0);         //This was necessary for my AD to do anything
 ldap_bind($cnx,$LDAPUser.$dn,$LDAPUserPassword) or die("Could not bind to LDAP");
  
  
  }
  
  
  error_reporting (E_ALL ^ E_NOTICE);   //Suppress some unnecessary messages
  
  
?>