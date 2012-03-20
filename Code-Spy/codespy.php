<?php
// Codespy PHP code coverage analyzing tool version 2.0
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
	public static $coveredlines = array();
	public static $executable_statements = array();
	public static $executionbranches = array();
	public static $instancenumberfor = array();
	public static $possiblebranches = array();
	public static $nodetrees = array();
	public static $outputformat = 'txt';
	public static $outputdir = '';
	public static $file_to_cover=array();
	public static $functions_to_analayze = array();
	public static $coveredcolor = '#ffc2c2';
	public function __destruct()
	{
		$coverages = array();
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
			$style =<<<EOB
			<!DOCTYPE html>
			<style>
			body{
			font: 14px/1 "Lucida Grande","Lucida Sans Unicode",Lucida,Arial,Helvetica,sans-serif;
			}
			table.index {
			border-spacing:0px;
			width:100%;
			}
			table.index tr th{
			border-bottom:solid 1px #d0d0d0;
			border-left:solid 1px #d0d0d0;
			color:gray;
			text-align:left;
			padding:3px;
			}

			table.index tr td{
			padding:3px;
			}
			table.index tr.odd td{
			padding:3px;
			background-color:#e5e5e5;
			}
			</style>
EOB;
			stream_wrapper_restore('file');
			foreach(self::$coveredlines as $file=>$lines) {
				if(self::shouldpatchfile($file)) {
					$patcher = new patcher(file_get_contents($file));
					$patched = $patcher->patch(array(1,2,3,6));
					file_put_contents(self::$outputdir."/".basename($file).".cc.temp",$patched);
					$file_lines = file(self::$outputdir."/".basename($file).".cc.temp");
					unlink(self::$outputdir."/".basename($file).".cc.temp");
					$output = "<body style='font-family:monospace;'>";
					$maxlen = strlen(count($file_lines).max(self::$coveredlines[$file])) +1;
					$covered_lines=0;
					if(isset(Analyzer::$possiblebranches[$file])) foreach(Analyzer::$possiblebranches[$file] as  $class =>$filebranches) {
						$output .= "\nFor Class <h3>$class:</h3>\n<br/>";
						foreach($filebranches as $file_1=>$branches) { $output .= "<hr/>Function:&nbsp;<h3>$file_1"."</h3><br/>Execution node tree constructed from source. Paths in red are the ones that actually executed.<br/>";	
							$highlightpaths = array();
							foreach(self::$executionbranches[$file][$class][$file_1] as $path) {  ($highlightpaths[] = join(',',array_keys($path)));}
							ob_start();
							Analyzer::$nodetrees[$file][$class][$file_1]->dumpNode(0,array(),$highlightpaths);
							$output .= ob_get_clean();
							$output .= "<br/>Possible execution paths:".($pp = count($branches))."\n<br/>";
							$output .= "<div style='overflow:auto;width:400px;height:200px;'>";
							foreach($branches as $b) $output .= join(',',$b)."\n<br/>";
							$output .= "</div>";
							$output .= "\n<br/>Paths covered:".($cp = count($highlightpaths = array_unique($highlightpaths)))."\n\n<br/><br/>";
							$output .= "Covered Paths:\n<br/>";
							foreach($highlightpaths as $path) {  $output .= ($path."\n<br/>");}
							$output .= "\n<br/>";
							$output .= "Path covereage :".(($cp*100)/$pp)."%\n\n<br/><br/>";
						}
					}
				} else {
				$file_lines = file($file);
				$maxlen = strlen(count($file_lines).max(self::$coveredlines[$file])) +1;
				$covered_lines=0;
				$output = '';
				}
				//foreach(self::$executionbranches as $functionname=>$paths) {$output .=$functionname."<br/>"; foreach($paths as $path)  $output .= join(',',array_keys($path))."\n<br/>";}
				foreach($file_lines as $k=>$line) 
					if(isset($lines[$k+1]) && $lines[$k+1]>0) {
						$output .= "<span  style='font-family:monospace;background-color:#a0ffa0'>".str_pad(($k+1).':'.$lines[$k+1],$maxlen,'0',STR_PAD_LEFT)."</span><pre style='font-family:monospace;display:inline;margin:0px;background-color:".self::$coveredcolor.";font-family:monospace;padding-left:5px'>".rtrim(preg_replace('/\(codespy-execution-node:([0-9.]+)\)/','<span style=\'color:red;font-weight:bold;font-size:22;padding:10px;\'>\1</span>',"". htmlentities($line)))."</pre><br/>";
						$covered_lines+=1;
					} else
						$output .=  "<span style='font-family:monospace;background-color:#a0ffa0'>".str_pad($k+1,$maxlen,'0',STR_PAD_LEFT)."</span><pre style='font-family:monospace;margin:0px;display:inline;padding-left:10px'>".rtrim(preg_replace('/\(codespy-execution-node:([0-9.]+)\)/','<span style=\'color:red;font-size:22;font-weight:bold\'>\1</span>',"".htmlentities($line)))."</pre><br/>";
				$coverage = ($covered_lines/count($file_lines))*100;
				$actual_coverage = ($covered_lines*100/Analyzer::$executable_statements[$file]);
				$coverages[$file] = $coverage;
				$actual_coverages[$file] = $actual_coverage;
				$output = "~Line Coverage=<b>".$coverage."%</b><br/><br/>".$output;
				$output = "~Statement Coverage=<b>".$actual_coverage."%</b>,&nbsp;&nbsp;".$output;
				if(self::$outputdir) {
					file_put_contents(self::$outputdir."/".($visual_report_file[$file] = preg_replace("/[:\\/\\\]/",'-',$file).".cc.html"),$style.$output);
				}
			}
			ob_start();
			echo "$style<table class='index'><tr><th>File Name</th><th>Line Coverage</th><th>~Statement Coverage</th><th>View Report</th></tr>";
			$rc=0;
			foreach((array)$coverages as $file=>$coverage) {
				$coverage = number_format($coverage,2);
				echo "<tr ".(($rc++%2==1)?"class='odd'":"")."><td>$file</td><td>$coverage %</td><td>{$actual_coverages[$file]} %</td><td><a href='{$visual_report_file[$file]}'>View Coverage</a></td></tr>";
			}
			echo "</table>";
			$index_content = ob_get_clean();
			file_put_contents(self::$outputdir."/index.html",$index_content);
		
		} else {
			foreach(self::$coveredlines as $file=>$lines) {
				$total_lines = count($lines);
				$lines = array_filter($lines,function($x) { return $x>0;});
				echo PHP_EOL.$file,' :  ',PHP_EOL,join(',',array_keys($lines)).PHP_EOL;
				echo PHP_EOL."Code Coverage percentage=".((count($lines)/$total_lines)*100).PHP_EOL;
			}
		}
	}
	public static function shouldpatchfile($file)
	{
			foreach(self::$functions_to_analayze as $item) if($item[0] == $file ) return true;
	}
	public static function shouldpatch($function,$class ='')
	{
		$function = strtolower($function);
		$class = strtolower($class);
		if($class) {
			foreach(self::$functions_to_analayze as $item) {
				if($item[1] == $function && $item[2] == $class) return true;
			}
		} else {
			foreach(self::$functions_to_analayze as $item) {
				if($item[1] == $function && $item[2]=='' ) return true;
			}
		}
	}
	public static function addFunctionToAnalyze($file,$function_name,$class='')
	{
		if($file = realpath($file))
		array_push(self::$functions_to_analayze,array($file,strtolower($function_name),strtolower($class)));
	}
	public static function addFileToSpy($path)
	{
		array_push(self::$file_to_cover,realpath($path));
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
		if((in_array($path,self::$file_to_cover) === false) && count(self::$file_to_cover)>0) return $source;
		self::$coveredlines[$path] = array_fill(1,$lc,0);
	 	$patcher = new patcher($source);
		if(count(self::$functions_to_analayze)>0)
			return $patcher->patch(array(1,2,3,4,5),$path);
		else 
			return $patcher->patch(array(1,2,3,4),$path);
	}
	static function add_to_patch($token,$offset)
	{

	}
	
	public function exception_handler($e)
	{
		$this->__destruct();
		throw $e;
	}
	
}

class patcher
{
	function __construct($source)
	{
		$this->source = array($source); 
		$this->current_pass = 0;
		$this->break_levels = array();
		$this->break_nodes = array();
		$this->continue_nodes = array();
		$this->return_nodes = array();
		$this->jumps = array();
		$this->tokens_to_be_inserted_after = array();
		$this->tokens_to_be_replaced = array();
	}

	private function get_till($tokens,$search_token,$start)
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
	private function get_previous_non_comment($tokens,$start,$return_content = false)
	{
		while(isset($tokens[$start])) {
			if(is_array($tokens[$start])) {
				$token_name = token_name($tokens[$start][0]);
				$token_content = $tokens[$start][1];
				if($token_name == 'T_WHITESPACE' || $token_name=='T_COMMENT' || $token_name== 'T_MLCOMMENT') {
					$start--;
					continue;
					}
				if($return_content) return $token_content;else return $start;
			} else return $start;
			$start--;
		}
		return false;
	}
	private function get_next_non_comment($tokens,$start,$return_content = false)
	{
		while(isset($tokens[$start])) {
			if(is_array($tokens[$start])) {
				$token_name = token_name($tokens[$start][0]);
				$token_content = $tokens[$start][1];
				if($token_name == 'T_WHITESPACE' || $token_name=='T_COMMENT' || $token_name== 'T_MLCOMMENT') {
					$start++;
					continue;
					}
				if($return_content) return $token_content;else return $start;
			} else return $start;
			$start++;
		}
		return false;
	}
	public function patch($passes=array(),$path='')
	{
		$pass = 0;
		$this->last_pass = 0;
		foreach($passes as $pass) {
			if(method_exists($this,$method_name = 'pass_'.$pass)) {
				$this->current_pass = $pass;
				$this->tokens_to_be_inserted_after = array();
				$this->tokens_to_be_replaced = array();
				$this->$method_name($path);
				$this->last_pass = $pass;
			}
		}
		//echo $this->source[$this->current_pass];
		return $this->source[$this->current_pass];
	}
	private function add_tokens_to_be_inserted_after($tp,$token,$node=false)
	{
		if($node === false) {
			if(isset($this->tokens_to_be_inserted_after[$tp][$token])) 
				$this->tokens_to_be_inserted_after[$tp][$token] += 1;
			else 
				$this->tokens_to_be_inserted_after[$tp][$token] = 1;
		} else {
		$token = "(codespy-execution-node:$node)";
		if(isset($this->tokens_to_be_inserted_after[$tp][$token])) 
			$this->tokens_to_be_inserted_after[$tp][$token] += 1;
		else 
			$this->tokens_to_be_inserted_after[$tp][$token] = 1;
		}
	}
	private function add_tokens_to_be_replaced($tp,$token)
	{
		if(isset($this->tokens_to_be_replaced[$tp][$token])) 
			$this->tokens_to_be_replaced[$tp][$token] += 1;
		else 
			$this->tokens_to_be_replaced[$tp][$token] = 1;
	}
	private function change_stuff()
	{
		$tp=0;
		$out = '';
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		while($tp < $token_count) {
			if(isset($this->tokens_to_be_inserted_after[$tp])) {
				foreach($this->tokens_to_be_inserted_after[$tp] as $k=>$v) {
					$out .= str_repeat($k,$v);
				}
			}
			if(isset($this->tokens_to_be_replaced[$tp])) {
				foreach($this->tokens_to_be_replaced[$tp] as $k=>$v) {
					$out .= str_repeat($k,$v);
				}
			} else{
				$out .= $this->token_content($tokens[$tp]);
			}
			$tp++;
		}
		return $out;
	}
	//replace else if with elseif
	public function pass_1()
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_of_interest = array('T_ELSE');
		while($tp < $token_count) {
			if($this->token_name($tokens[$tp]) == 'T_ELSE' ){
			$temp = $this->get_next_non_comment($tokens,$tp+1);
			if($this->token_name($tokens[$temp]) == 'T_IF') {
					$this->add_tokens_to_be_replaced($tp ,'elseif');
					$this->add_tokens_to_be_replaced($temp ,'');
				}
			}
			$tp++;
		}
		$this->source[$this->current_pass] = $this->change_stuff() ;
		
	}
	
	//convert alternate syntax to conventional syntax, convert colons after case to ';'.
	public function pass_2()
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_of_interest = array('T_IF','T_FOR','T_FOREACH','T_ELSE','T_ELSEIF','T_WHILE','T_SWITCH');
		$tokens_of_interest_1 = array('T_ENDIF','T_ENDWHILE','T_ENDFOR','T_ENDSWITCH');
		while($tp < $token_count) {
			if(in_array($token_name = $this->token_name($tokens[$tp]), $tokens_of_interest )){
				if($token_name == 'T_DO') {

				} else {
					$temp = $this->get_next_non_comment($tokens,$tp+1);
					if($this->token_name($tokens[$temp]) == '(') {
							$temp = $this->get_pair($tokens,$temp);
							$temp = $this->get_next_non_comment($tokens,$temp+1);
						} 	
						if($this->token_name($tokens[$temp]) == ':') {
							$this->add_tokens_to_be_replaced($temp,'{');
							if($token_name == 'T_ELSEIF' || $token_name == 'T_ELSE') {
								$this->add_tokens_to_be_inserted_after($tp,'}');
							}
						}
				}
			} elseif(in_array($token_name,$tokens_of_interest_1)) {
				$this->add_tokens_to_be_replaced($tp,'}');
				$this->add_tokens_to_be_replaced($this->get_next_non_comment($tokens,$tp+1),' ');
			} elseif($token_name == 'T_CASE' || $token_name == 'T_DEFAULT') {
				//jump over the ternary operators to get the last colon
				if($this->search_token($tokens,$tp,'?',array(';'))) {
				while($tmp = $this->search_token($tokens,$tp,'?',array(';'))) $tp = $tmp+1;
				if($tmp =  $this->search_token($tokens,$tp,':',array(';')))  $tp = $tmp+1;
				}
				if($temp =  $this->search_token($tokens,$tp,':',array(';'))) {
					$this->add_tokens_to_be_replaced($temp ,';');
				}
			}
			$tp++;
		}
		
		$this->source[$this->current_pass] = $this->change_stuff() ;
	}
	
	// enclode inline if,elseif,for,while statements to blocks.
	public function pass_3()
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_of_interest = array('T_IF','T_FOR','T_FOREACH','T_ELSE','T_ELSEIF','T_WHILE','T_DO');
		while($tp < $token_count) {
			$ct = $tokens[$tp];
			if(in_array($this->token_name($ct), $tokens_of_interest )){
				while(in_array($token_name = $this->token_name($ct), $tokens_of_interest )) {
					$temp = $this->get_next_non_comment($tokens,$tp+1);
					if($this->token_name($tokens[$temp]) == '(') {
						$temp = $this->get_pair($tokens,$temp);
						$next = $this->get_next_non_comment($tokens,$temp+1);
					} else 
						$next = $temp;
					$ct = $tokens[$next];
					if(!in_array($this->token_name($tokens[$next]), array('{',':',';'))) {
						$this->add_tokens_to_be_inserted_after($next,'{');
						if($token_name == 'T_IF') 
							$this->add_tokens_to_be_inserted_after($this->get_if_end($tokens,$tp)+1,'}');
						else
							$this->add_tokens_to_be_inserted_after($this->get_statement_end($tokens,$next)+1,'}');

					}
					$tp = $next;
				}
			} 
			$tp++;
		}
		$this->source[$this->current_pass] = $this->change_stuff() ;
	}
	// inject trace code in statements
	public function pass_4($path = '')
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_to_jump_parenthesis = array('T_IF','T_FOR','T_FOREACH','T_ELSEIF','T_WHILE');
		$tokens_to_patch = array('T_FUNCTION');
		$tokens_to_stop_patching = array('T_CLASS','T_TRAIT','T_INTERFACE');
		$offset = 0;
		$suspend = true;
		$inclass = false;
		$executable_statements = 0;
		while($tp < $token_count) {
			$token_name = $this->token_name($tokens[$tp]);
			if(in_array($token_name, $tokens_to_patch )) {
				if($blockstart = $this->search_token($tokens,$tp,'{',array(';'))) {
					if(!isset($blockend)) $blockend = $this->get_pair($tokens,$blockstart);
					$suspend = false;
				}
			} elseif(in_array($token_name, $tokens_to_stop_patching )) {
				if($blockstart = $this->search_token($tokens,$tp,'{',array(';'))) {
					$inclass = true;
					$classend = $this->get_pair($tokens,$blockstart);
					$suspend = true;
				}
			}
			if($inclass && $tp >= $classend) {
				$inclass = false;
			};
			if($suspend && $inclass) {
				$tp++;
				continue;
				} else {
				if(isset($blockend) && $tp >= $blockend) {
					$suspend = true;
					$tp++;
					unset($blockend);
					continue;
					}
				}
				if(in_array($token_name, $tokens_to_jump_parenthesis )) {
					$temp = $this->get_next_non_comment($tokens,$tp+1);
					if($this->token_name($tokens[$temp]) == '(') {
						$temp = $this->get_pair($tokens,$temp);
						$tp = $this->get_next_non_comment($tokens,$temp+1);
					}
				} elseif($token_name =='T_END_HEREDOC') {
					if($this->token_name($tokens[$temp = $this->get_next_non_comment($tokens,$tp+1)]) == ';') {
						$offset++;
						$this->add_tokens_to_be_inserted_after($temp+1,PHP_EOL.'\codespy\Analyzer::$coveredlines[__FILE__][__LINE__-'.$offset.']+=1;');
						$tp = $temp+1;
					}

				} elseif($token_name == ';') {
					$executable_statements++;
					$this->add_tokens_to_be_inserted_after($tp+1,'\codespy\Analyzer::$coveredlines[__FILE__][__LINE__-'.$offset.']+=1;');
				} elseif($token_name == 'T_RETURN' || $token_name == 'T_THROW' || $token_name == 'T_BREAK' || $token_name == 'T_CONTINUE') {
					$this->add_tokens_to_be_inserted_after($tp,'\codespy\Analyzer::$coveredlines[__FILE__][__LINE__-'.$offset.']+=1;');

				}
			$tp++;
		}
		Analyzer::$executable_statements[$path] = $executable_statements;

		$this->source[$this->current_pass] = $this->change_stuff() ;
		
	}
	//Add branch analysis code
	public function pass_5($path)
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_to_patch = array('T_FUNCTION');
		$last_class = '';
		while($tp < $token_count) {
			$token_name = $this->token_name($tokens[$tp]);
			if($token_name == 'T_NAMESPACE') $current_namespace =  $this->token_content($tokens[$this->get_next_non_comment($tokens,$tp+1)]);
			if($token_name == 'T_CLASS') {
			$last_class = $this->token_content($tokens[$this->get_next_non_comment($tokens,$tp+1)]);
			if(isset($current_namespace)) $last_class = $current_namespace."\\".$last_class;
			}
			if(in_array($token_name, $tokens_to_patch )) {
				if($blockstart = $this->search_token($tokens,$tp,'{',array(';'))) {
					 $function_name_tp = $this->get_next_non_comment($tokens,$tp+1);
					 if(!is_array($tokens[$function_name_tp])) 
						 $function_name_tp = $this->get_next_non_comment($tokens,$function_name_tp+1);
					 $function_name = $tokens[$function_name_tp][1];
					 if(!Analyzer::shouldpatch($function_name,$last_class)) {
					 	$tp++;
						continue;
					 } 
					 Analyzer::$instancenumberfor[$function_name] = 0;
					 $this->add_tokens_to_be_inserted_after($blockstart+1,"/*0*/"."if(isset(\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__])) \\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]++; else \\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]=0;\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][0] = 1;");
					 $blockend = $this->get_pair($tokens,$blockstart);
					 $children = $this->get_children_from($tokens,$blockstart,$blockend,0);
					 Analyzer::$possiblebranches[$path][$last_class][$function_name] = $children->getPaths();
					 Analyzer::$nodetrees[$path][$last_class][$function_name] = $children;
				}
			} 
				
			$tp++;
		}
	$this->source[$this->current_pass] =  $this->change_stuff();
	}
	
	//for-output-only copy of pass 5
	public function pass_6()
	{
		$tokens = token_get_all($this->source[$this->last_pass]);
		$token_count = count($tokens);
		$tp = 0;
		$tokens_to_patch = array('T_FUNCTION');
		$last_class = '';
		while($tp < $token_count) {
			$token_name = $this->token_name($tokens[$tp]);
			if($token_name == 'T_NAMESPACE') $current_namespace =  $this->token_content($tokens[$this->get_next_non_comment($tokens,$tp+1)]);
			if($token_name == 'T_CLASS') {
			$last_class = $this->token_content($tokens[$this->get_next_non_comment($tokens,$tp+1)]);
			if(isset($current_namespace)) $last_class = $current_namespace."\\".$last_class;
			}
			if(in_array($token_name, $tokens_to_patch )) {
				if($blockstart = $this->search_token($tokens,$tp,'{',array(';'))) {
					 $function_name_tp = $this->get_next_non_comment($tokens,$tp+1);
					 if(!is_array($tokens[$function_name_tp])) 
						 $function_name_tp = $this->get_next_non_comment($tokens,$function_name_tp+1);
					 $function_name = $tokens[$function_name_tp][1];
					 if(!Analyzer::shouldpatch($function_name,$last_class)) {
					 	$tp++;
						continue;
					 }
					 //Analyzer::$instancenumberfor[$function_name] = 0;
					 $this->add_tokens_to_be_inserted_after($blockstart+1,"",0);
					 $blockend = $this->get_pair($tokens,$blockstart);
					 $children = $this->get_children_from($tokens,$blockstart,$blockend,0,$temp,true);
					 //Analyzer::$possiblebranches[$function_name] = $children->getPaths();
				}
			} 
				
			$tp++;
		}
		$this->source[$this->current_pass] =  $this->change_stuff();
	}
	private function get_children_from_switch($tokens,&$tp,$parent_node,&$last_node = null,$foroutput = false)
	{
		$start  = $this->search_token($tokens,$tp,'(',array(';'));
		$start = $this->get_pair($tokens,$start);
		$start  = $this->search_token($tokens,$start,'{',array(';'));
		$end = $this->get_pair($tokens,$start);
		$this->break_levels[] = $end;
		$current_node_id = $parent_node;
		$tree = new tree;
		while($tp = $this->search_token($tokens,$tp,array('T_CASE','T_DEFAULT'),array('}')) ) {
		if($this->token_name($tokens[$tp]) == 'T_DEFAULT' ) $founddefault = true;

		//jump over the ternary operators to get the last colon
		$case_end = $this->get_end_of_case($tokens,$tp+1);
		
		if($temp =  $this->search_token($tokens,$tp,array(';','T_CLOSE_TAG'))) {
			$case_start = $temp;
			$new_node = $current_node_id = $current_node_id + 1;
			if(!in_array($parent_node,$this->break_nodes)) $tree->addChild($parent_node,$new_node);
			$this->add_tokens_to_be_inserted_after($case_start+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
			if($children = $this->get_children_from($tokens,$case_start,$case_end,$current_node_id,$current_node_id,$foroutput)) {
				$tree->addChildren($children);

			}
		}
		$tp = $case_end;
		}
		$new_node = $current_node_id+1;
		if(!isset($founddefault))
			if(!in_array($parent_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes))) $tree->addChild($parent_node,$new_node);
		$tree->addChildToAllLeavesOfParent($parent_node,$new_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes));
		if(isset($this->jumps[$end])) {
			foreach($this->jumps[$end] as $jn) {
				$tree->addChild($jn,$new_node);
				}
		}
		$this->add_tokens_to_be_inserted_after($end+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		$last_node = $new_node;
		$tp = $end;
		array_pop($this->break_levels);
		return $tree;

	}
	private function get_children_from_boolean($tokens,&$start,$end,$parent_node,$group_node,&$last_node = null,$foroutput=false)
	{
		$new_node = $parent_node;
		$tree = new tree;
		while($start<=$end) {
			$token_name = $this->token_name($tokens[$start]);
			if(in_array($token_name,array('T_BOOLEAN_AND','T_BOOLEAN_OR'))) {
				$new_node++;
				$tree->addChild($parent_node,$new_node);
				$parent_node = $new_node;
				$this->add_tokens_to_be_inserted_after($start," && (\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1)",$foroutput?"$new_node":$foroutput);
				$src_node = $new_node;
				if($this->token_name($tokens[$start = $this->get_next_non_comment($tokens,$start+1)]) == '('){
					$group_node = $new_node++;
					$tree->addChild($src_node,$new_node);
					$this->add_tokens_to_be_inserted_after($start+1,"(\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1)&&",$foroutput?($group_node+1):$foroutput);
					$thisend = $this->get_pair($tokens,$start);
					$last_node = $new_node;
					if($node_children = $this->get_children_from_boolean($tokens,$start,$thisend,$new_node,$group_node+1,$last_node,$foroutput)) {
						$tree->addChildren($node_children);
					}
					$parent_node = $new_node = $last_node;
					$tree->addChildToAllDecendants($src_node,$new_node+1);
					continue;
				}
			}
			$start++;
		}
		$last_node = $new_node;
		return $tree;

	}



	

	private function get_children_from_if($tokens,&$start,$parent_node,&$last_node,$foroutput = false)
	{
		$tree = new tree;
		$current_node_id = $parent_node;
		$tp = $start;
		$tree = new tree;
		while(1) {
			$token_name = $this->token_name($tokens[$this->get_next_non_comment($tokens,$tp)]);
			if(in_array($token_name,array('T_IF','T_ELSE','T_ELSEIF'))) {
				if($token_name == 'T_ELSE') { $elsefound = true;
					$start  = $this->search_token($tokens,$tp,'{',array(';'));
				} else {
					if($token_name == 'T_IF') {
						if(isset($found_if)) break;
						$found_if = true;
					}
					$boolleft = $start  = $this->search_token($tokens,$tp,'(',array(';'));
					$boolright = $start = $this->get_pair($tokens,$start);
					$temp_current_node = $current_node_id;
					$parent_node_old = $parent_node;
					if( $node_children =$this->get_children_from_boolean($tokens,$boolleft,$boolright,$current_node_id,$current_node_id,$current_node_id,$foroutput) ) {
						if($temp_current_node != $current_node_id) {
							$parent_node = $current_node_id;
							$tree->addChildToAllDecendants($temp_current_node+1,$current_node_id+1);
						}
						$tree->addChildren($node_children);
					}
					$start  = $this->search_token($tokens,$start,'{',array(';'));
				}
				$end = $this->get_pair($tokens,$start);

				$new_node = $current_node_id = $current_node_id + 1;
				if(!in_array($parent_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes))) {
					$tree->addChild($parent_node,$new_node);
				}
				$this->add_tokens_to_be_inserted_after($start+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
				if($children = $this->get_children_from($tokens,$start,$end,$current_node_id,$current_node_id,$foroutput)) {
					$tree->addChildren($children);
				}
				$tp = $end+1;
			} else break;


		}
		$new_node = $current_node_id+1;
		if(!isset($elsefound)) {
			if(!in_array($parent_node_old,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes))) $tree->addChild($parent_node_old,$new_node);
		} 	
		echo "Pn = $parent_node_old";
		$tree->addChildToAllLeavesOfParent($parent_node,$new_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes));
		$this->add_tokens_to_be_inserted_after($end+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		$last_node = $new_node;
		$start = $end;
		array_pop($this->break_levels);
		return $tree;
	}
	private function get_children_from_loop($tokens,&$start,$parent_node,&$last_node,$foroutput = false)
	{
		$tree = new tree;
		$current_node_id = $parent_node;
		$tp = $start;
		$tree = new tree;
		$start  = $this->search_token($tokens,$tp,'(',array(';'));
		$start = $this->get_pair($tokens,$start);
		if(!($temp= $this->search_token($tokens,$start,'{',array(';')))) return false;
		$start = $temp;
		$end = $this->get_pair($tokens,$start);
		$this->break_levels[] = $end;

		$new_node = $current_node_id = $current_node_id + 1;
		if(!in_array($parent_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes))) $tree->addChild($parent_node,$new_node);
		$this->add_tokens_to_be_inserted_after($start+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		if($children = $this->get_children_from($tokens,$start,$end,$current_node_id,$current_node_id,$foroutput)) {
			$tree->addChildren($children);
			}
		$tp = $end+1;
		$new_node = $current_node_id+1;
		if(!in_array($parent_node,$this->break_nodes)) $tree->addChild($parent_node,$new_node);
		$tree->addChildToAllLeavesOfParent($parent_node,$new_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes));
		if(isset($this->jumps[$end])) {
			foreach($this->jumps[$end] as $jn) {
				$tree->addChild($jn,$new_node);
				}
		}
		$this->add_tokens_to_be_inserted_after($end+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		$last_node = $new_node;
		$start = $end;
		array_pop($this->break_levels);
		return $tree;
	}
	private function get_children_from_do($tokens,&$start,$parent_node,&$last_node,$foroutput = false)
	{
		$tree = new tree;
		$current_node_id = $parent_node;
		$tp = $start;
		$tree = new tree;
		if(!($temp= $this->search_token($tokens,$start,'{',array(';')))) return false;
		$start = $temp;
		$end = $this->get_pair($tokens,$start);
		$this->break_levels[] = $end;

		$new_node = $current_node_id = $current_node_id + 1;
		if(!in_array($parent_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes))) $tree->addChild($parent_node,$new_node);
		$this->add_tokens_to_be_inserted_after($start+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		if($children = $this->get_children_from($tokens,$start,$end,$current_node_id,$current_node_id,$foroutput)) {
			$tree->addChildren($children);
			}
		$tp = $end+1;
		$tp = $this->search_token($tokens,$tp,'(');
		$end = $this->get_pair($tokens,$tp)+1;
		$new_node = $current_node_id+1;
		if(!in_array($parent_node,$this->break_nodes)) $tree->addChild($parent_node,$new_node);
		$tree->addChildToAllLeavesOfParent($parent_node,$new_node,array_merge($this->break_nodes , $this->continue_nodes,$this->return_nodes));
		if(isset($this->jumps[$end])) {
			foreach($this->jumps[$end] as $jn) {
				$tree->addChild($jn,$new_node);
				}
		}
		$this->add_tokens_to_be_inserted_after($end+1,"/*$new_node*/"."\\codespy\\Analyzer::\$executionbranches[__FILE__][__CLASS__][__FUNCTION__][\\codespy\\Analyzer::\$instancenumberfor[__FILE__][__CLASS__][__FUNCTION__]][$new_node] = 1;",$foroutput?$new_node:false);
		$last_node = $new_node;
		$start = $end;
		array_pop($this->break_levels);
		return $tree;
	}


	private function  get_children_from($tokens,$start,$end,$parent_node,&$last_node = null,$foroutput=false)
	{
		$branch_points = array('T_IF','T_FOR','T_FOREACH','T_WHILE','T_SWITCH','T_DO','T_BOOLEAN_OR','T_BOOLEAN_AND');
		$tp = $start;
		$tree= new tree;
		$current_node_id = $parent_node;
		$this->break_nodes = $this->return_nodes = $this->continue_nodes = array();
		while($tp<$end) {
			$token_name = $this->token_name($tokens[$tp]);
			if($token_name == 'T_FUNCTION') {
				if($blockstart = $this->search_token($tokens,$tp,'{',array(';'))) {
					if($tp = $this->get_pair($tokens,$blockstart)) { $tp++;continue;}
				}
			} elseif($token_name == 'T_BREAK') {
				$level = $this->get_break_level($tokens,$tp);
				$break_target = $this->break_levels[count($this->break_levels)-$level];
				$this->jumps[$break_target][] = $current_node_id;
				$this->break_nodes[] = $current_node_id;
			} elseif($token_name == 'T_CONTINUE') {
				$this->continue_nodes[] = $current_node_id;
			} elseif($token_name == 'T_RETURN' || $token_name == 'T_THROW') {
				$this->return_nodes[] = $current_node_id;
			}
			
			elseif(in_array($token_name, $branch_points)) {
				if($token_name == 'T_SWITCH') {
				/*
				$trace = debug_backtrace(false);
				foreach ($trace as $t) var_dump($t['function']);
				*/
					$node_children = $this->get_children_from_switch($tokens,$tp,$current_node_id,$current_node_id,$foroutput);
					$tree->addChildren($node_children);
				}elseif(in_array($token_name,array('T_IF'))) {
						$temp = $current_node_id;
						$node_children = $this->get_children_from_if($tokens,$tp,$current_node_id,$current_node_id,$foroutput);
						$tree->addChildren($node_children);
					} elseif($token_name == 'T_DO') {
						if( $node_children = $this->get_children_from_do($tokens,$tp,$current_node_id,$current_node_id,$foroutput))
						$tree->addChildren($node_children);
					}
				elseif(in_array($token_name,array('T_BOOLEAN_AND','T_BOOLEAN_OR')) ) {
					$boolright = $this->get_right_of_boolean($tokens,$tp);
					if( $node_children =$this->get_children_from_boolean($tokens,$tp,$boolright,$current_node_id,$current_node_id,$current_node_id,$foroutput)) {
						$tree->addChildren($node_children);
					}
				}
				else {
					if( $node_children = $this->get_children_from_loop($tokens,$tp,$current_node_id,$current_node_id,$foroutput))
					$tree->addChildren($node_children);
					}
				} 
			$tp++;
		}
		$last_node = $current_node_id;
		return $tree;
	}
	public function get_right_of_boolean($tokens,$tp)
	{
		if($temp = $this->search_token($tokens,$tp+1,array(':' ,'?', '.' , ';' , ',' ,')','T_CLOSE_TAG','T_BOOLEAN_OR','T_BOOLEAN_AND'),array(),true)) return $this->get_previous_non_comment($tokens,$temp-1);
	}
	public function get_left_of_boolean($tokens,$tp)
	{
		if($temp = $this->search_back($tokens,$tp-1,array('{','(',';','T_OPEN_TAG',',','?',':','T_BOOLEAN_OR','T_BOOLEAN_AND'),array(),true)) return $this->get_next_non_comment($tokens,$temp+1);
	}

	public function get_break_level($tokens,$tp)
	{
	if($this->token_name($token = $tokens[$this->get_next_non_comment($tokens,$tp+1)]) == 'T_LNUMBER') return (($temp = $this->token_content($token))>0)?$temp:1; else return 1;
	}

	public function get_ternary_statement_end($tokens,$start)
	{
	$token_count = count($tokens);

	$tp = $start;
	$qm_count = 0;
	while($tp<$token_count) {
	$token_name = $this->token_name($tokens[$tp]);
	if($token_name ==';' || ($token_name ==':' && $qm_count==0) || $token_name == 'T_CLOSE_TAG') break;
	elseif($token_name == '?') $qm_count++;
	elseif($token_name == ':') $qm_count--;
	elseif($token_name == '(') $tp = $this->get_pair($tokens,$tp);
	$tp++;
	}
	return $tp;
	}
	public function get_context($tokens,$tp,$offset= 3)
	{
	$start = ($tp>$offset) ? $tp-$offset: 0;
	$end = ($tp+$offset < count($tokens))?$tp+$offset: count($tokens)-1;
	return $this->get_contents($tokens,$start,$end);

	}
	public function get_contents($tokens,$start,$end) 
	{
	$return = '';
	for(;$start<=$end;$start++) {
		if(is_array($tokens[$start])) $return .= $tokens[$start][1];else $return .= $tokens[$start];
		}
	return $return;
	}
	public function get_ternary_sub_statements($tokens,$start)
	{
		$tp =$real_start = $this->get_next_non_comment($tokens,$start+1);
		$token_count = count($tokens);
		$qm_count = 0;
		while(($tp<$token_count) && ( ($token_name = $this->token_name($tokens[$tp])) !=':' || ($qm_count > 0) ) ) {
			if($token_name == '?') $qm_count++;
			elseif($token_name == ':') $qm_count--;
			$tp++;
		}
		$mid_segment_end = $tp;
		$end = $this->get_ternary_statement_end($tokens,$tp+1);
		return array($start,$mid_segment_end,$end);
	}
	private function get_end_of_case($tokens,$start)
	{
		$token_count = count($tokens);
		while($start< $token_count) {
			$token_name = $this->token_name($tokens[$start]);
			if($token_name == '}' || $token_name == 'T_BREAK'|| $token_name == 'T_CONTINUE') return $start;
			elseif($token_name == '{') $start = $this->get_pair($tokens,$start)+1;
			else $start++;
		}
	}
	private function search_back($tokens,$start,$search,$breakon = array(),$jump_para = false)
	{
		$token_count = count($tokens);
		while($start> 0) {
			$token_name = $this->token_name($tokens[$start]);
			if($token_name == ')' && $jump_para) {
				$start = $this->get_pair($tokens,$start,-1)-1;
				continue;
			}
			if($breakon && in_array($token_name,$breakon)) return false;
			if(is_array($search)) {
				if(in_array($token_name,$search)) return $start;

			} else {
				if($token_name == $search) return $start;
			}
			$start--;
		}
	}
	private function search_token($tokens,$start,$search,$breakon = array(),$jump_para = false)
	{
		$token_count = count($tokens);
		while($start< $token_count) {
			$token_name = $this->token_name($tokens[$start]);
			if($token_name == '(' && $jump_para) {
				$start = $this->get_pair($tokens,$start,1);
				$start++;
				continue;
			}
			if($breakon && in_array($token_name,$breakon)) return false;
			if(is_array($search)) {
				if(in_array($token_name,$search)) return $start;

			} else {
				if($token_name == $search) return $start;
			}
			$start++;
		}
	}
	private function get_statement_start($tokens,$end)
	{
		while($end>0 && in_array($this->token_name($tokens[$end]), array(';','}','T_WHITESPACE'))) $end--; 
		while($end>0 && !in_array($token_name = $this->token_name($tokens[$end]), array('{',';','T_COMMENT','T_ML_COMMENT','T_DOC_COMMENT'))) {
			if($token_name != 'T_WHITESPACE') $last_non_whitespace = $end;
			if($token_name == ')') $end = $this->get_pair($tokens,$end,-1);else $end--;
			}
		return $last_non_whitespace;	
	}
	private function get_statement_end($tokens,$start)
	{
		while(isset($tokens[$start])) {
			$token_name = $this->token_name($tokens[$start]);
			if($token_name == 'T_IF') return $this->get_if_end($tokens,$start);
			if($token_name == ';') 
				return $start;
			elseif(in_array($token_name,array('(','[')))
				$start = $this->get_pair($tokens,$start);
			elseif($token_name == '{')
				return $this->get_pair($tokens,$start);
			else
				$start++;
		}
	}
	private function get_if_end($tokens,$start,$full=false)
	{
	$tp = $start;
	$next = $this->get_statement_after_if($tokens,$tp);
	$token_name = $this->token_name($tokens[$next]);
	if($token_name == 'T_IF' )
		$end = $this->get_if_end($tokens,$next,true);
	elseif($token_name == '{' ) 
		$end = $this->get_pair($tokens,$next);
	else 
		$end = $this->get_statement_end($tokens,$next);
	if(!$full) return $end;
	while($this->token_name($tokens[$next = $this->get_next_non_comment($tokens,$end+1)]) == 'T_ELSEIF') {
		$end = $this->get_if_end($tokens,$next);
	}
	if($this->token_name($tokens[$next]) == 'T_ELSE') {
		return $this->get_if_end($tokens,$next);
	} else return $end;

	}
	private function get_statement_after_if($tokens,$start)
	{
	if($this->token_name( $tokens[$next =$this->get_next_non_comment($tokens,$start+1)]) == '(')
		return $this->get_next_non_comment($tokens,$this->get_pair($tokens,$next)+1);
	else 
		return $this->get_next_non_comment($tokens,$start+1);
	}

	private function get_pair($tokens,$start,$dir = 1)
	{
		$pairs = array('{'=>'}','['=>']','('=>')','}'=>'{',']'=>'[',')'=>'(');
		$src = $this->token_name($tokens[$start]);
		if(isset($pairs[$src ])) {
			$pair = $pairs[$src ];
			$count = 1;
			while($count>0) {
				if($dir == 1) 
					$start = $next = $this->get_next_non_comment($tokens,++$start);
				else 
					$start = $next = $this->get_previous_non_comment($tokens,--$start);

				if($next!==false) 
					$next = $this->token_name($tokens[$next]); 
				else 
					return false;
				if($next == 'T_CURLY_OPEN' || $next == 'T_DOLLAR_OPEN_CURLY_BRACES' ) $next = '{';
				if($next == $src) 
					$count++;
				elseif($next == $pair) 
					$count--;
			}
			return $start;
		}
	}

	private function token_content($token)
	{
		if(is_array($token)) {
			if(isset($token[0])) {
				return $token[1];
				}
			else 
				return false;
			} else {
				return $token;
			}
	}
	private function token_name($token)
	{
		if(is_array($token)) {
			if(isset($token[0])) {
				return token_name($token[0]);
				}
			else 
				return false;
			} else {
				return $token;
			}
	}

	
}
class tree{
private $nodes = array();
private $paths= array();
public function __construct($nodes=array())
	{
		if($nodes) $this->nodes = $nodes;
	}
public function nodes()
{
	return $this->nodes;
}
public function dumpNode($node,$path=array(),$highlightpaths=array())
{
	if(isset($this->nodes[$node])) {
		$path[] = $node;
		$path_str = join(',',$path);
		$highlight = false;
		foreach($highlightpaths as $v) {
			if(strpos($v,$path_str) === 0) $highlight = true;
		}
		if(count($this->nodes[$node]) == 0) {
		if($highlight)	echo "<span style='color:red'>$node</span>";else echo $node;
		} else {
			if($highlight) $cont = "<span style='color:red'>$node</span>";else $cont = $node;
			echo "<table style='border:solid 1px gray;'><tr><td>$cont</td></tr><tr><td><table><tr>";
			foreach($this->nodes[$node] as $n) {
				echo "<td valign=top>";
				$this->dumpNode($n,$path,$highlightpaths);
				echo "</td>";
			}
			echo "</tr</td></table></td></table>";
		}
	}
}

public function addChildren($tree)
	{
		foreach($tree->getNodes() as  $k=>$nodes) {
			foreach($nodes as $v ) {
				$this->addChild($k,$v);
			}
		}
	}
public function addChildToAllDecendants($parent,$child,$exclude = array())
{
	while(1) {
		$this->addChild($parent,$child);
		if(isset($this->nodes[$parent][0])) $parent = $this->nodes[$parent][0]; else break;
		if($parent == $child) break;
	}
}

public function addChildToAllLeavesOfParent($parent,$child,$exclude = array())
	{
		foreach($this->getLeavesForTreeAt($parent,$exclude) as $leaf) {
			if(!in_array($leaf,$exclude) && $leaf!=$child) {
			$this->addChild($leaf,$child);
			}
		}

	}
public function getLeavesForTreeAt($parent,$exclude = array())
	{
		$leaves = array();
		$paths = $this->getPaths($parent);
		foreach($paths as $path) {
			foreach($exclude as $en) if(in_array($en,$path)) continue 2;
			$leaves[] = end($path);
		}
		return $leaves;
	}
public function getSiblings($node)
	{
	$siblings = array();
	foreach($this->getParents($node) as $parent) {
		$siblings = array_merge($siblings,$this->nodes[$parent]);
	}
	return $siblings;

	}
public function getParents($node)
	{
	$return = array();
	foreach($this->nodes as $k=>$v) {
			if(($found = array_search($node,$v)) !== false  ) {
				$return[] = $k;
			}
		}
	return $return;
	}
public function getNodes()
	{
		return $this->nodes;
	}
public function addChild($parent,$child)
	{
	if(isset($this->nodes[$parent])) {
		if(in_array($child,$this->nodes[$parent]) === false  ) {
			array_push($this->nodes[$parent],$child);
			if(!isset($this->nodes[$child])) $this->nodes[$child] = array();
			}
		}
	else {
		$this->nodes[$parent] = array($child);
		if(!isset($this->nodes[$child])) $this->nodes[$child] = array();
		}
	}
public function getPaths($root=0)
	{
		$this->paths = array();
		$this->dfs($root);
		return ($this->paths);
	}
public function dfs($parent,$path = array())
	{
		if(!$path) $path = array($parent);
		$visited = array();
		if(isset($this->nodes[$parent]) && count($this->nodes[$parent]) >0) {
			while(($child = $this->getUnvisitedChild($parent,$visited)) !== false )  {
				$visited[$child]=1;
				$this->dfs($child,$temp = array_merge($path,array($child)));
			}
		} else {
			$this->paths[] = $path;
		}

	}
public function getUnvisitedChild($parent,$visited)
	{
		if(isset($this->nodes[$parent])) foreach($this->nodes[$parent] as $v) {
			if(!isset($visited[$v])) return $v;
		}
		return false;
	}
}
stream_wrapper_unregister("file");
stream_wrapper_register("file", "codespy\str_wrp");
$_codecoverage_object_to_call_upon_exit = new analyzer;
set_exception_handler(array($_codecoverage_object_to_call_upon_exit,'exception_handler'));
