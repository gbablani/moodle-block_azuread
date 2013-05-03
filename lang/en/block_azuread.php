<?php

/*******************************************************************************
Copyright (C) 2012  Microsoft Corporation. All rights reserved.
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*******************************************************************************/

  $string['blockname']='Office 365 Login';
  $string['blocklogo']='Block Logo';
  $string['blocklogodesc']='This is the text that will be displayed on the login block top';
  $string['pluginname'] = 'Azure Active Directory';  
  $string['warningauthmismatch']='You are logged in using a non Office 365 user name. Please logout using this link';
  $string['AADNotEnabled']='AzureAD auth plugin is not enabled. Please contact your moodle administrator';
  $string['officeLink']='Open Office 365 portal';
  $string['profileLink']='Edit Office 365 Profile';
  $string['identityNotSignedIn']='Not logged in';    
  $string['identitySignInText']='Sign into Office 365';
  $string['identitySignInButtonText']='Sign In';
  $string['configTitle']='Title of block';
  $string['symmkey']='Symmetric key';
  $string['symmkeydesc']='Symmetric key from registering Moodle with Azure Active Directory';
  $string['companydomain']='University Domain';
  $string['companydomaindesc']='University domain registered with Office365';
  $string['companyid']='University Id';
  $string['companyiddesc']='University id from registering Moodle app';
  $string['appid']='Application Id';
  $string['appiddesc']='Application ID from registering Moodle app';
  $string['azureadSPNNotSet']='Your Office 365 plugin is not configured. Administrator please setup Appid in AzureAD plugin settings';
  $string['azureadSyncToken']='AzureAD SyncToken';
  $string['azureadSyncTokendesc']='This value should not be changed or modified. Its written as a base64 string by the Azure sync engine. The only acceptable change is to blank it out. This will force resyncing of all users from Azure AD';
$string['azureadNotDoSync']='DisAllow Sync';
  $string['azureadNotDoSyncdesc']='This value determines whether Moodle syncs users from Office365 or not';
