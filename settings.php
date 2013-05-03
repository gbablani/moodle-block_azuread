
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

  $settings->add(new admin_setting_configtext(
            'block_azuread/blocklogo',
            get_string('blocklogo', 'block_azuread'),
            get_string('blocklogodesc', 'block_azuread'),
            get_string('blockname','block_azuread')
        ));
  $settings->add(new admin_setting_configtext(
            'block_azuread/companyid',
            get_string('companyid', 'block_azuread'),
            get_string('companyiddesc', 'block_azuread'),
            null
        ));
  $settings->add(new admin_setting_configtext(
            'block_azuread/companydomain',
            get_string('companydomain', 'block_azuread'),
            get_string('companydomaindesc', 'block_azuread'),
            null
        ));
  $settings->add(new admin_setting_configtext(
            'block_azuread/appid',
            get_string('appid', 'block_azuread'),
            get_string('appiddesc', 'block_azuread'),
            null
        ));      
  $settings->add(new admin_setting_configtext(
            'block_azuread/symmkey',
            get_string('symmkey', 'block_azuread'),
            get_string('symmkeydesc', 'block_azuread'),
            null
        ));      
  $settings->add(new admin_setting_configcheckbox(
            'block_azuread/azureadNotDoSync',
            get_string('azureadNotDoSync', 'block_azuread'),
            get_string('azureadNotDoSyncdesc', 'block_azuread'),0
            
        ));
  $settings->add(new admin_setting_configtext(
            'block_azuread/azureadSyncToken',
            get_string('azureadSyncToken', 'block_azuread'),
            get_string('azureadSyncTokendesc', 'block_azuread'),
            null
        ));      
        
?>
