<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 29/05/14
 * Time: 8:38 PM
 */

class errHandle {
    private $file = "/logs/error_log";

    public function debugtrace($functToCall, $msg = "Error"){
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $this->$functToCall($caller['line'], $caller['file'], $msg);
    }

    public function html_wrapped($errLine, $errFile, $errMsg, $class='global'){

        $html = '<div class="'.$class.' error-msg">' .
            '<span class="errLine">Line : ' . $errLine . '</span><br/>' .
            '<span class="errFile">File : ' . $errFile . '</span><br/>' .
            '<span class="errMsg">Message : ' . $errMsg . '</span><br/>' .
            '</div>';

        print $html;

    }

    public function html_wrapped_pos($errLine=null, $errFile=null, $errMsg=null, $class = '', $pos=null, $fadeout=false, $return=false){

        $html = '<div class="global injected'.$class.' error-msg" style="display: none;">';
        if(!empty($errLine)){
            $html .= '<span class="errLine">Line : ' . $errLine . '</span><br/>';
        }
        if(!empty($errFile)){
            $html .= '<span class="errFile">File : ' . $errFile . '</span><br/>';
        }
        if(empty($errMsg)){
            $errMsg = "Unknown Error has Occurred";
        }
        $html .= '<span class="errMsg">Error : ' . $errMsg . '</span><br/>' . '</div>';

        $pos = $pos || ['top' => '30px'];

        $script = '<script type="text/javascript">'.
            //'(function(){' .
            'var html =  \''.$html.'\'; '.
            '$(html).css("top", "'.$pos['top'].'");';

        $script .= isset($pos['left']) ? '$(html).css("left",'.$pos['left'].');' : '';

        $script .= '$(".error-msg").hide();'.
            '$(".midContent").css("position","relative");'.
            '$(".midContent").prepend(html);';

        $script .= $fadeout == true ? '$(".error-msg").fadeIn().delay(1000).fadeOut();' : '$(".error-msg").fadeIn();';

        $script .= '</script>'; //'});'

        if($return){
            //var_dump($script);
            return $script;
        }else{
            print $script;
        }


    }

    public function log_to_file($errLine, $errFile, $errMsg, $filePath=null){
        try{
            if($filePath == null){
                $filePath = _ROOT . $this->file;
            }
            $file = fopen($filePath, "a");
            $string = "ERROR: $errMsg => LINE: $errLine => FILE: $errFile\n";

            fputs($file, $string);
            fclose($file);
        }catch (Exception $e){
            //$this->html_wrapped($e->getLine(), $e->getFile(), $e->getMessage());
        }
    }

    public function log_to_file_msg($msg, $filePath=null){
        try{
            if($filePath == null){
                $filePath = _ROOT . $this->file;
            }
            $file = fopen($filePath, "a");
            if($file !== false){
                fputs($file, $msg."\n");
                fclose($file);
            }
        }catch (Exception $e){

        }
    }

} 