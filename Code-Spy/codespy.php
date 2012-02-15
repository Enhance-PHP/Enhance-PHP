<?php
namespace codespy;
/*

Copyright (c) 2012 Sandeep.C.R, <sandeepcr2@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

class str_wrp
{
    public $resource;
    public $patched_content;
    public $path;
    function wr()
    {
        stream_wrapper_unregister("file");
        stream_wrapper_register("file", __CLASS__);
    }
    function unwr()
    {
        stream_wrapper_restore('file');
    }
    function stream_open($path, $mode, $options, &$openedPath)
    {
        $this->path = $path;
        $this->unwr();
        $this->resource = fopen($path, $mode, $options);
        $this->wr();
        return $this->resource !== false ;
    }

    function stream_close()
    {
        $this->unwr();
        $return = fclose($this->resource);
        $this->wr();
        return $return;
    }

    function stream_eof()
    {
        return ($this->offset < $this->length);
    }

    function stream_flush()
    {
        $this->unwr();
        $return = fflush($this->resource);
        $this->wr();
        return $return;
    }

    function stream_read($count)
    {
        $this->unwr();
        if(!$this->patched_content) {
            $this->offset = 0;
            $lines = 0;
            while (!feof($this->resource)) {
                if ($line = fgets($this->resource)) {
                    $this->content .= $line;
                    $lines++;
                }
            }
            $this->patched_content = analyzer::load($this->content,$this->path,$lines);
            $this->length = strlen($this->patched_content);
        }
        $this->wr();
        $return = substr($this->patched_content,$this->offset,$count);
        $this->offset += $count;
        return $return;
    }

    function stream_seek($offset, $whence = SEEK_SET)
    {
        $this->unwr();
        $return = fseek($this->resource, $offset, $whence) === 0;
        $this->offset = $offset;
        $this->wr();
        return $return;
    }

    function stream_stat()
    {
        $this->unwr();
        $return = fstat($this->resource);
        $this->wr();
        return $return;

    }

    function stream_tell()
    {
        $this->unwr();
        $return = ftell($this->resource);
        $this->wr();
        return $return;
    }

    function url_stat($path, $flags)
    {
        stream_wrapper_restore('file');
        $result = @stat($path);
        stream_wrapper_unregister("file");
        stream_wrapper_register("file", '\codespy\str_wrp');
        return $result;
    }

    function dir_closedir()
    {
        $this->unwr();
        $return = closedir($this->resource);
        $this->wr();
        return $return;
    }

    function dir_opendir($path, $options)
    {
        $this->unwr();
        if (isset($this->context)) {
            $this->resource = opendir($path, $this->context);
        } else {
            $this->resource = opendir($path);
        }
        $return = $this->resource !== false;
        $this->wr();
        return $return;
    }

    function dir_readdir()
    {
        $this->unwr();
        $return = readdir($this->resource);
        $this->wr();
        return $return;
    }

    function dir_rewinddir()
    {
        $this->unwr();
        $return = rewinddir($this->resource);
        $this->wr();
        return $return;
    }

    function mkdir($path, $mode, $options)
    {
        $this->unwr();
        if (isset($this->context)) {
            $result = mkdir($path, $mode, $options, $this->context);
        } else {
            $result = mkdir($path, $mode, $options);
        }
        $this->wr();
        return $result;
    }

    function rename($path_from, $path_to)
    {
        $this->unwr();
        if (isset($this->context)) {
            $result = rename($path_from, $path_to, $this->context);
        } else {
            $result = rename($path_from, $path_to);
        }
        $this->wr();
        return $result;
    }

    function rmdir($path, $options)
    {
        $this->unwr();
        $return = rmdir($path, $options);
        $this->wr();
        return $return;
    }

    function stream_cast($cast_as)
    {
        $this->unwr();
        $return = $this->resource;
        $this->wr();
        return $return;
    }

    function stream_lock($operation)
    {
        $this->unwr();
        $return = flock($this->resource, $operation);
        $this->wr();
        return $return;
    }

    function stream_set_option($option, $arg1, $arg2)
    {
        throw new Exceptions\NotImplemented(__METHOD__);
    }

    function stream_write($data)
    {
        $this->unwr();
        $return = fwrite($this->resource, $data);
        $this->wr();
        return $return;
    }

    function unlink($path)
    {
        $this->unwr();
        if (isset($this->context)) {
            $result = unlink($path, $this->context);
        } else {
            $result = unlink($path);
        }
        $this->wr();
        return $result;
    }

}
class analyzer
{
    public static $inistackcount=0;
    public static $stack = array();
    public static $last_trace_node=0;
    public static $file_to_cover=array();
    public static $coveredlines = array();
    public static $outputformat = 'txt';
    public static $outputdir = '';
    public static $coveredcolor = '#ffc2c2';
    public function __destruct()
    {
        if(self::$outputformat == 'vim') {
            foreach(self::$coveredlines as $file=>$lines) {
                //echo PHP_EOL.$file,' :  ',join(',',array_keys($lines));
                $lines = array_filter($lines,function($x) { return $x>0;});
                echo PHP_EOL.$file,PHP_EOL,'match cursorline /\%',join('l\|\%',array_keys($lines))."l/";
            }
        } elseif(self::$outputformat == 'php') {
            echo var_export(self::$coveredlines,true);
            echo "Code Coverage percentage=".($covered_lines/count($file_lines))*100;
        } elseif(self::$outputformat =='html') {
            stream_wrapper_restore('file');
            foreach(self::$coveredlines as $file=>$lines) {
                $file_lines = file($file);
                $output = '';
                $maxlen = strlen(count($file_lines).max(self::$coveredlines[$file])) +1;
                $covered_lines=0;
                foreach($file_lines as $k=>$line)
                    if(isset($lines[$k+1]) && $lines[$k+1]>0) {
                        $output .= "<span  style='font-family:monospace;background-color:#a0ffa0'>".str_pad(($k+1).':'.$lines[$k+1],$maxlen,'0',STR_PAD_LEFT)."</span><pre style='display:inline;margin:0px;background-color:" . self::$coveredcolor . ";font-family:monospace'>".rtrim(htmlentities($line))."</pre><br/>";
                        $covered_lines+=1;
                    } else
                        $output .=  "<span style='font-family:monospace;background-color:#a0ffa0'>".str_pad($k+1,$maxlen,'0',STR_PAD_LEFT)."</span><pre style='margin:0px;display:inline'>".rtrim(htmlentities($line))."</pre><br/>";
                $output .= "<b>Code Coverage percentage</b>=".($covered_lines/count($file_lines))*100;
                if(self::$outputdir) {
                    file_put_contents(self::$outputdir."/".basename($file).".cc.html",$output);
                }
            }

        } else {
            foreach(self::$coveredlines as $file=>$lines) {
                $total_lines = count($lines);
                $lines = array_filter($lines,function($x) { return $x>0;});
                echo PHP_EOL.$file,' :  ',PHP_EOL,join(',',array_keys($lines)).PHP_EOL;
                echo PHP_EOL."Code Coverage percentage=".((count($lines)/$total_lines)*100).PHP_EOL;
            }
        }
    }
    public static function addFileToSpy($path)
    {
        array_push(self::$file_to_cover,$path);
    }

    static function trace($lines,$file)
    {
        if(isset(self::$coveredlines[$file][$lines])) self::$coveredlines[$file][$lines]+=1;else self::$coveredlines[$file][$lines]=1;
    }

    static function match($f1,$f2)
    {
        $f1_array = explode('::',$f1);
        $f2_array = explode('::',$f2);
        if(!class_exists($f2_array[0])) return false;
        if(isset($f1_array[1])) return( (is_subclass_of($f2_array[0],$f1_array[0]) || $f2_array[0]==$f1_array[0]) && ($f1_array[1]==$f2_array[1])) ;
        else return  (is_subclass_of($f2_array[0],$f1_array[0]) || $f2_array[0]==$f1_array[0]) ;
    }

    static function load($source,$path,$lc)
    {
        //$files = array_merge(get_included_files(),self::$files);
        //if(in_array(realpath($file),$files)) return false;
        //self::$files[] = realpath($file);
        if((in_array($path,self::$file_to_cover) === false) && count(self::$file_to_cover)>0) return $source;
        $context = $patch = '';
        $stack = array();
        $tokens = token_get_all($source);
        $token_count = count($tokens);
        self::$coveredlines[$path] = array_fill(1,$lc,0);
        $last_function = '';
        $capture_input = false;
        $capture_function = '';
        $function_fragments = array();
        $patched_capture = '';
        $nested_function_stack = array();
        $parethesis_stack = array();
        $curlybraseadded = 0;
        $inparenthisis = false;
        for($k = 0 ; $k<$token_count ; $k++) {
            $v = $tokens[$k];
            if(is_string($v)) {
                if($capture_input) {
                    $patched_capture .= $v;
                }
                if($v == '(') {
                    array_push($parethesis_stack,'(');
                    $inparenthisis = true;
                    $patch .= $v;
                } elseif($v ==')') {
                    array_pop($parethesis_stack);
                    if(count($parethesis_stack)==0) {
                        if($context == 'loopstart') {
                            $context = '';
                            $temp = self::get_next_non_comment($tokens,$k+1);
                            if(0 && $temp != ':' && $temp != '{' && $temp != ';') {
                                $patched .= '{\profiler::trace($____profiler,\profiler::$trace_variables?compact(\profiler::$trace_variables):get_defined_vars(),__LINE__-$____profiler_start_line);';
                                $curlybraseadded += 1;
                            }
                        }
                        $inparenthisis = false;
                    }else $inparenthisis = true;
                    $patch .= $v;
                } else if($v == ';') {
                    $next_non_comment = self::get_next_non_comment($tokens,$k+1);
                    if(($curlybraseadded>0) && $next_non_comment != 'T_ELSE' &&  $next_non_comment != 'T_ELSEIF')
                    {
                        if(!$inparenthisis && $capture_input)
                            $patched_capture .= str_repeat('}',$curlybraseadded);
                        $curlybraseadded = 0;
                        $patch .= ';';
                    }
                    else if($context != 'class' && $next_non_comment != 'T_ELSE' &&  $next_non_comment != 'T_ELSEIF' ) {
                        $patch .= ';';
                        if(!$inparenthisis && $capture_input)  $patch .= '\codespy\Analyzer::$coveredlines[__FILE__][__LINE__]+=1;';
                    } else {
                        $patch .= ';';
                    }
                } elseif($v == '{') {
                    array_push($stack,$context);
                    $patch .= $v;
                } elseif($v == '}' && 0) {
                    $stack_top = array_pop($stack);
                    if($stack_top == 'function' && (array_search('function',$stack)===false)) {
                        $capture_input = false;
                        $function_fragments[$last_function] = $patched_capture;
                        $patch .= "{if(isset(\$____profiler)) \profiler::close(\$____profiler);} }";
                    } elseif($stack_top == 'class') {
                        foreach($function_fragments as $kk=>$vv) {
                            $vv = ltrim($vv);
                            if(substr($vv,0,1)=='&') {
                                $vv = ltrim($vv,'& ');
                                $patch .= "\n function & trace_patch_$vv ";
                            } else {
                                $patch .= "\n function  trace_patch_$vv ";

                            }
                        }
                        $patch .=  $v;
                        $function_fragments = array();
                        $patched_capture = '';
                    } else {
                        $patch .= $v;
                    }
                    $context = '';
                } else $patch .= $v;
            }else {
                if($capture_input) {
                    $patched_capture .= $v[1];
                    if(token_name($v[0]) == 'T_END_HEREDOC') {
                        $patched_capture .= PHP_EOL;
                    }
                }
                switch(token_name($v[0])) {
                    case 'T_FOR':
                    case 'T_FOREACH':
                    case 'T_WHILE':
                        $context = 'loopstart';
                        break;
                    case 'T_DO':
                        $temp = self::get_next_non_comment($tokens,$k+1);
                        if($temp != ':' && $temp != '{') {
                            if(!$inparenthisis && $capture_input)
                                $patched_capture .= '{';
                            $curlybraseadded = true;
                        }
                        break;
                    case 'T_CLASS':
                    case 'T_INTERFACE':
                        $context = 'class';
                        $last_class = self::get_next_non_comment($tokens,$k+1,true);
                        break;
                    case 'T_FUNCTION':
                        if(array_search('function',$stack)!==false) break;
                        $context = 'function';
                        $temp= self::get_till($tokens,'T_STRING',$k+1);
                        if($this_function = join('',$temp) ){
                            $last_function = $this_function;
                            $patched_capture = '';
                        }
                        if($last_function) $capture_input = true;
                        break;
                    case 'T_RETURN':
                        $return_exp = '';
                        $temp = false;
                        while(isset($tokens[$k]) && ($scan_token = $tokens[++$k]) !== ';')
                        {
                            if(is_array($scan_token) )  {
                                $return_exp .= $scan_token[1];
                                if(token_name($scan_token[0]) != 'T_WHITESPACE') $temp = true;
                            } else {
                                $return_exp .= $scan_token;
                                $temp = true;
                            }

                        }
                        if($temp)  {
                            $patch .= "{\\codespy\\Analyzer::\$coveredlines[__FILE__][__LINE__]+=1;return $return_exp;}";
                            if($capture_input) $patched_capture .=" $return_exp;";
                        } else {
                            $patch.="{\\codespy\\Analyzer::\$coveredlines[__FILE__][__LINE__]+=1;return;}";
                            $patched_capture .=" ; ";
                        }
                        $next_non_comment = self::get_next_non_comment($tokens,$k+1);
                        if( $next_non_comment != 'T_ELSE' &&   $next_non_comment != 'T_ELSEIF'  ) $patch .= ';';
                        $v[1] = '';
                        break;
                    case 'T_THROW':
                        $return_exp = '';
                        $temp = false;
                        while(isset($tokens[$k]) && ($scan_token = $tokens[++$k]) !== ';')
                        {
                            if(is_array($scan_token) )  {
                                $return_exp .= $scan_token[1];
                                if(token_name($scan_token[0]) != 'T_WHITESPACE') $temp = true;
                            } else {
                                $return_exp .= $scan_token;
                                $temp = true;
                            }

                        }
                        if($temp)  {
                            $patch .= "{\\codespy\\Analyzer::\$coveredlines[__FILE__][__LINE__]+=1;throw $return_exp;}";
                            if($capture_input) $patched_capture .=" $return_exp;";
                        } else {
                            $patch.="{\\codespy\\Analyzer::\$coveredlines[__FILE__][__LINE__]+=1;return;}";
                            $patched_capture .=" ; ";
                        }
                        $next_non_comment = self::get_next_non_comment($tokens,$k+1);
                        if( $next_non_comment != 'T_ELSE' &&   $next_non_comment != 'T_ELSEIF'  ) $patch .= ';';
                        $v[1] = '';
                        break;
                    case 'T_DOLLAR_OPEN_CURLY_BRACES':
                    case 'T_STRING_VARNAME';
                    case 'T_CURLY_OPEN';
                        array_push($stack,$context);
                        break;

                }
                $patch .= $v[1];
            }
        }
        //$patch = substr($patch,6);
        //if($last_class) file_put_contents("temp_$last_class.php",$patch);

        return ($patch);
    }
    static function get_till($tokens,$search_token,$start)
    {
        $return = array();
        while(isset($tokens[$start])) {
            if(is_array($tokens[$start])) {
                $token_name = token_name($tokens[$start][0]);
                $token_content = $tokens[$start++][1];
                $return[] = $token_content;
                if($token_name == $search_token ) return $return;

            } else {
                $return[] =$tokens[$start];
                if($search_token == $tokens[$start++]) return $return;
            }
        }
        return false;
    }
    static function get_next_non_comment($tokens,$start,$return_content = false)
    {
        while(isset($tokens[$start])) {
            if(is_array($tokens[$start])) {
                $token_name = token_name($tokens[$start][0]);
                $token_content = $tokens[$start++][1];
                if($token_name == 'T_WHITESPACE' || $token_name=='T_COMMENT' || $token_name== 'T_MLCOMMENT') continue;
                if($return_content) return $token_content;else return $token_name;
            } else return $tokens[$start];
        }
        return false;
    }
    public function exception_handler($e)
    {
        $this->__destruct();
        throw $e;
    }

}
stream_wrapper_unregister("file");
stream_wrapper_register("file", "codespy\str_wrp");
$_codecoverage_object_to_call_upon_exit = new analyzer;
set_exception_handler(array($_codecoverage_object_to_call_upon_exit,'exception_handler'));
