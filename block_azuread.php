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

    if( !defined( 'MOODLE_INTERNAL' ) )
    {
        die( 'Direct access to this script is forbidden.' );    ///  It must be included from a Moodle page
    }

    require_once( $CFG->dirroot . '/blocks/azuread/utils.php' );
    require_once( $CFG->libdir . '/sessionlib.php' );
    require_once( $CFG->libdir . '/moodlelib.php' );
    require_once( $CFG->dirroot . '/auth/azuread/graph.php' );

    /* Returns false in case of success*/
    function get_signinURL(&$signinUrl)
    {
        global $CFG;
        $appid = get_config('block_azuread','appid');
        if( $appid == false )
        {
            $content_html = util_getLocalizedString( 'azureadSPNNotSet' );
            return $content_html;
        }

        $CFG->httpswwwroot = str_replace('http:', 'https:', $CFG->wwwroot);
        $azureadReplyURL = $CFG->httpswwwroot.'/auth/azuread/logincallback.php';

        $compid = get_config('block_azuread','companydomain');
        if( $compid == false )
        {
            $content_html = util_getLocalizedString( 'azureadSPNNotSet' );
            return $content_html;
        }
        $signinparam = "wa=wsignin1.0&wtrealm=".urlencode($appid)."&wreply=".urlencode($azureadReplyURL);
        $signinUrl = "https://login.windows.net/".$compid."/wsfed?".$signinparam;
        return null;
    }   

    function get_signoutURL(&$signoutUrl)
    {
        $ret = get_signinURL($azureadReplyURL);
        if (isset($ret))
            return $ret;
        $signoutURL=str_replace('wa=wsignin1.0','wa=wsignout1.0',$azureadReplyURL);
        return $ret;
    }   
    /**
    * The block_AAD is the block override class for Azure Active Directory plug in
    */
    class block_azuread extends block_base
    {
        /**
        * The initialization function for the block
        */
        function init()
        {
            if( empty( $this->title ) )
            {
                $titleglob = get_config('block_azuread','blocklogo');
                if ($titleglob != false)
                    $this->title = $titleglob;
                else
                    $this->title = util_getLocalizedString('blockname');    
            }

        }



        /**
        * Renders the HTML content for the entire block
        * @return <string> (HTML)
        */
        function get_content()
        {
            global $USER,$COURSE,$CFG,$SESSION;

            // this function is called many times so stop re-entry
            if ( $this->content != NULL and isloggedin() and isset($SESSION->aaduser)) { return $this->content; }
            $signInButtonSrc = $CFG->wwwroot.'/blocks/azureAD/images/glossybutton88.gif';
            $offlogo = $CFG->wwwroot.'/blocks/azureAD/images/logo-office-365.png';
            // If someone is a guest or not logged in using AAD they see a warning
            if( isloggedin() and !isset($SESSION->aaduser)) {         
                $warning = util_getLocalizedString('warningauthmismatch');
                $this->content = new stdClass;
                /*$this->content->text = "<div> <p>$warning</p><a href=$CFG->wwwroot/login/logout.php?sesskey=".sesskey().">".get_string('logout')."</a> </div>";
                */
                $lo = "$CFG->wwwroot/login/logout.php?sesskey=".sesskey();
                $lotext = get_string('logout');
                $this->content->text= "<div><table border=2>
                <tr>
                <td>

                <img alt=\"\" src=\"$offlogo\" style=\"background: transparent\" /> 

                </td>
                </tr>
                <tr>
                <td>

                $warning

                <a  href=\"$lo\" id=\"Submit1\" style=\"background:transparent url($signInButtonSrc) no-repeat scroll top right;height: 32px;width:88px;display: block;float:left;margin:0px;text-decoration: none;text-align:center;color: #333333;font-family: 'Segoe UI', Arial, Helvetica, sans-serif;font-size:1.2em;font-weight:normal;\" >$lotext</a><br />

                </td>
                </tr>
                </table></div>";

                $this->content->footer = '';
                return $this->content;
            }

            // store the value and return the content
            $this->content = new stdClass;
            $this->content->text = $this->Render();
            $this->content->footer = '';

            return $this->content;
        }

        function preferred_width() {
            return 210;
        }
        /* Renders the core block - gives link to O365 if logged ged and redirects to auth if not logged in */
        function Render()
        {
            global $USER,$CFG,$SESSION;
            $content_html = '';
            $signInButtonSrc = $CFG->wwwroot.'/blocks/azureAD/images/glossybutton88.gif';
            $offlogo = $CFG->wwwroot.'/blocks/azureAD/images/logo-office-365.png';
            // do not show the block if the "AAD" auth module is missing or disabled
            if( is_enabled_auth( 'azuread' ) != 1 )
            {
                $content_html = util_getLocalizedString( 'AADNotEnabled' );
                return $content_html;
            }

            // If they are logged in show a link to Office and other friendly info, otherwise show login button
            if (isset($SESSION->aaduser))
            {                    
                $displayName = $SESSION->aadusername;
                $profileUrl = 'https://portal.microsoftonline.com/EditProfile.aspx';
                $officeUrl = 'https://portal.microsoftonline.com/IWDefault.aspx';
                $officeLink = util_getLocalizedString( 'officeLink' );
                $profileLink = util_getLocalizedString( 'profileLink' );
                // User's Profile link
                $content_html= "<div><table border=2>
                <tr>
                <td>

                <img alt=\"\" src=\"$offlogo\" style=\"background: transparent\" /> 

                </td>
                </tr>
                <tr>
                <td>

                $displayName

                <a  href=\"$profileUrl\" id=\"Submit1\" style=\"background:transparent url($signInButtonSrc) no-repeat scroll top right;height: 32px;width:88px;display: block;float:left;margin:0px;text-decoration: none;text-align:center;color: #333333;font-family: 'Segoe UI', Arial, Helvetica, sans-serif;font-weight:lighter;\" >$profileLink</a><br />
                <a  href=\"$officeUrl\" id=\"Submit1\" style=\"background:transparent url($signInButtonSrc) no-repeat scroll top right;height: 32px;width:88px;display: block;float:left;margin:0px;text-decoration: none;text-align:center;color: #333333;font-family: 'Segoe UI', Arial, Helvetica, sans-serif;font-weight:lighter;\" >$officeLink</a><br />

                </td>
                </tr>
                </table></div>";

            }else
            {
                $identityNotSignedIn = util_getLocalizedString( 'identityNotSignedIn' );
                $identitySignInText = util_getLocalizedString('identitySignInText');
                $identitySignInButtonText = util_getLocalizedString('identitySignInButtonText');

                $errorcode = get_signinURL($signInUrl);
                if (isset($errorcode))
                    return $errorcode;

                $content_html= "<div style=\" \"><table border=2>
                <tr>
                <td>

                <img alt=\"\" src=\"$offlogo\" style=\"  background: transparent\" /> 

                </td>
                </tr>
                <tr>
                <td>


                <a  href=\"$signInUrl\" id=\"Submit1\" style=\"background:transparent url($signInButtonSrc) no-repeat scroll top right;height: 32px;width:88px;display: block;float:left;margin:0px;text-decoration: none;text-align:center;color: #333333;font-family: 'Segoe UI', Arial, Helvetica, sans-serif;font-size:1.2em;font-weight:normal;\" >$identitySignInButtonText</a><br />

                </td>
                </tr>
                </table></div>";

            }

            // close the wrap on the whole block
            $content_html .= '</div>';  
            return $content_html;
        }

        /**
        * Only allow one instance of this block and don't allow it to be configurable except
        * by an admin through config_global.html
        * @return <bool>
        */                              
        function instance_allow_config()
        {
            return false;
        }

        function specialization()
        {
            if( !empty( $this->config->title ) )
            {
                $this->title = $this->config->title;
            }
            else
            {
                $titleglob = get_config('block_azuread','blocklogo');
                if ($titleglob != false)
                    $this->title = $titleglob;
                else
                    $this->title = util_getLocalizedString('blockname');

            }

        }
        /**
        * Only allow one instance of this block and don't allow it to be configurable except
        * by an admin through config_global.html
        * @return <bool>
        */
        function instance_allow_multiple()
        {
            return false;
        }
        /**
        * Only allow one instance of this block and don't allow it to be configurable except
        * by an admin through config_global.html
        * @return <bool>
        */
        function has_config()
        {
            return true;
        }
        /**
        * Save configuration values
        * @param <array> $data
        * @return <bool>
        */
        function config_save( $data )
        {
            // Default behavior: save all variables as $CFG properties
            foreach( $data as $name => $value )
            {
                set_config( $name, $value );
            }
            return true;
        }
        /**
        * Show the block header
        * @return <bool>
        */
        function hide_header()
        {
            return false;
        }

        /**
        * not currently implemented
        * @return <bool>
        */
        function _self_test()
        {
            return true;
        }

    }
?>
