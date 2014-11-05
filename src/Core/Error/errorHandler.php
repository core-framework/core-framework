<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Error;

/**
 * Class to handle error
 *
 * @package Core\Error
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class errHandler {
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