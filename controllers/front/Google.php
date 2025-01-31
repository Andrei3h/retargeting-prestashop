<?php
/**
 * 2014-2021 Retargeting BIZ SRL
 * 
 * @author    Retargeting SRL <info@retargeting.biz>
 */

/**
 * Class Rtg_trackerStaticModuleFrontController
 */
class Rtg_trackerGoogleModuleFrontController extends ModuleFrontController
{
    private static $params = [
        'rtg_tracking_key'
    ];

    public function initContent()
    {
        $key = Configuration::get(self::$params[0]);

        $Link  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
        $Link .= "://{$_SERVER['HTTP_HOST']}";
        $checkKey = ( isset($_GET['key']) && !empty($key) && $_GET['key'] === $key );

        if( !$checkKey ){
            
            $message = "Wrong Key RTG Key!";
        }else if( $checkKey && isset($_GET['code']) && !isset($_GET['del']) ) {
            
            $outstream = fopen(_PS_ROOT_DIR_ . '/' . $_GET['code'] . '.html' , "w+") or die("Unable to open file!");
            fwrite($outstream, 'google-site-verification: ' . $_GET['code'] . '.html');
            fclose($outstream);

            $message = 'All Good, Please Check ' . $Link . '/' . $_GET['code'] . '.html';
        }else if ( $checkKey && isset($_GET['del']) ) {
            
            unlink( _PS_ROOT_DIR_ . '/' . $_GET['code'] . '.html' );

            $message = 'File Deleted, Please Check ' . $Link . '/' . $_GET['code'] . '.html';
        }

        echo $message ;
            
        exit(0);
    }
}