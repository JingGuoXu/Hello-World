<?php
	session_start();
	$_SESSION['str']="";
	require_once('analy.php');   //包含前端文件
	/**
	 * [ch_to_num description]
	 * @param  [type] $one_char [description]
	 * @return [type]           [description]
	 */
	function ch_to_num($one_char){ //将当前字符转换为数字表示的状态
		if($one_char==' ') return 0;//0代表空格
		elseif(($one_char>='a'&&$one_char<='z')
		||($one_char>='A'&&$one_char<='Z')||$one_char=='_') return 1;  //1代表字母
		elseif($one_char>='0'&&$one_char<='9') return 2;
		elseif($one_char=='.') return 2;   //2代表数字
		elseif($one_char=='>'||$one_char=='='||$one_char=='<') return 3;   //3代表大于小于等于
		elseif($one_char=="'") { return 4;}  //4代表单引号
		elseif($one_char=='"') { return 5;}  //5代表双引号
		else return 8;	//8代表其它终结符
	}
	function state_change($state_before,$one_char){   //状态改变后，用自动机确定下一个状态

		global $token;
		$ch_code=ch_to_num($one_char);   //首先将字符转换为数字状态
		switch ($state_before){   
			case 0:		//若前一个状态为空格						
				$_SESSION['str']=$one_char;
				break;
			case 1:     //若前一个状态为字母：若当前字符为空格，则自动机结束，保存
				if($ch_code==0&&$_SESSION['str']!=""){
						$token[]=$_SESSION['str'];
						$_SESSION['str']="";
						break;
					}
				elseif ($ch_code==1||$ch_code==2){   //若为1或2，继续读取下一个字符
					$_SESSION['str'].=$one_char;break;
				}
				elseif($ch_code==3){	//为3，则自动机结束，读取下一个字符
				$token[]=$_SESSION['str'];
				$_SESSION['str']=$one_char;
				break;
				}  
				elseif($ch_code==4||$ch_code==5){   //为4或5，自动机结束
					$_SESSION['str'].=$one_char;
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					break;
				}
				elseif($ch_code==8){  //若为8，自动机结束
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					$token[]=$one_char;
					break;
				}
			case 2:                    //字母和数字基本一致，故算法相同
				if($ch_code==0){  
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					break;
				}
				elseif ($ch_code==1||$ch_code==2){
					$_SESSION['str'].=$one_char;
					break;
				}
				elseif($ch_code==3){
					$token[]=$_SESSION['str'];
					$_SESSION['str']=$one_char;
					break;
				}
				elseif($ch_code==4||$ch_code==5){
					$_SESSION['str'].=$one_char;
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					//$token[]="'";
					break;
				}
				elseif($ch_code==5){
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					$token[]='"';
					break;
				}
				elseif($ch_code==8){
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					$token[]=$one_char;
					break;
				}
			case 3:
				if($ch_code==3){      //如果前一个为3，后一个也为3，说明为>=,<=,==中的一个
					$_SESSION['str'].=$one_char;
					$token[]=$_SESSION['str'];
					$_SESSION['str']=""; 
					break;
				}
				else {				//可以认为是终结符，自动机结束，读取当前字符
					$token[]=$_SESSION['str'];
					$_SESSION['str']=$one_char;
					break;
				}
			case 4:				//前一个为单引号，后一个为字母或数字，说明为当前字符
				if($ch_code==0&&strcmp($_SESSION['str'], "")!=0){   //为字符类型，其余情况自动机结束
					$token[]=$_SESSION['str'];         
					$_SESSION['str']="";
					break;}
				elseif($ch_code==3){   
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					$token[]=$one_char; 
					break;
				}
				elseif($ch_code==1||$ch_code==2){
					$_SESSION['str']="'";
					$_SESSION['str'].=$one_char;
					break;
				}
			case 5:				//前一个为双引号，后一个为字母或数字，说明
				if($ch_code==0){		//当前字符为字符串的开始，继续读取下一个字符
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					break;
				}
				elseif($ch_code==3){
					$token[]=$_SESSION['str'];
					$_SESSION['str']="";
					$token[]=$one_char; 
					break;
				}
				elseif($ch_code==1||$ch_code==2){
					$_SESSION['str']='"';
					$_SESSION['str'].=$one_char;
					break;
				}
			case 8:				//终结符，自动机结束
				if($ch_code==0){
					$token[]=$_SESSION['str'];
					break;
				}
				if($ch_code==1||$ch_code==2){
					$token[]=$_SESSION['str'];
					$_SESSION['str']=$one_char;
					break;}
				else {
				$token[]=$_SESSION['str'];
				$token[]=$one_char;
				$_SESSION['str']="";
				break;	
			}
		}
				
	}
	function check_table($str_check){    //查表，确定最终token类别码
		if($str_check=='int') return 4;
		if($str_check=='main')  return 5;
		if($str_check=='void') return 6;
		if($str_check=='if') return 7;
		if($str_check=='else') return 8;
		if($str_check=='char') return 9;
		if($str_check=='>=') return 10;
		if($str_check=='<=') return 11;
		if($str_check=='==') return 12;
		if($str_check=='=') return 13;
		if($str_check=='>') return 14;
		if($str_check=='<') return 15;
		if($str_check=='+') return 16;
		if($str_check=='-') return 17;
		if($str_check=='*') return 18;
		if($str_check=='/') return 19;
		if($str_check=='{') return 20;
		if($str_check=='}') return 21;
		if($str_check==',') return 22;
		if($str_check==';') return 23;
		if($str_check=='(') return 24;
		if($str_check==')') return 25;
		if($str_check=='[') return 26;
		if($str_check==']') return 27;
		$match_digit="/\d/";   //正则表达式来匹配数字
		if(preg_match($match_digit, $str_check)) return 3;
		$match_char="/^'/";		//正则表达式匹配字符类型
		if(preg_match($match_char, $str_check)) return 1;
		$match_string='/^"/';		//正则表达式匹配字符串类型
		if(preg_match($match_string, $str_check)) return 2;
		return 0;

	}
	//主程序
	if($_POST['textarea1']!=""){	//接受表单中POST传递过来的字符串保存
		$input_str=$_POST['textarea1'];//echo $input_str;
		$input_array=str_split($input_str);//将字符串转换成数组
		$state=0;  			//当前状态
		$state_before=0;	//前一个状态
		$token=array();		//token数组
		$length=count($input_array);
		//echo "$length";
		for($i=0;$i<$length;$i++){	//循环
			$state_before=$state;
			$state=ch_to_num($input_array[$i]);		//将当前字符装换成数字表示的状态
			state_change($state_before,$input_array[$i]);	//状态改变后，穿参数到自动机判断状态
		}

		$token_temp=$token;		//去除在输入过程中产生的多余的空格，换行，空字符
		$token=array();  
		for($i=0;$i<count($token_temp);$i++){
			if(strcmp($token_temp[$i], "")!=0
				&&strcmp($token_temp[$i], "\r")!=0
				&&strcmp($token_temp[$i], "\n")!=0
				&&strcmp($token_temp[$i], " ")!=0)
				{
					$token[]=$token_temp[$i];
				} 		
		}
		//print_r($token);
		//构造一个div，在div居中输出一个表格，前一列代表token，后一列代表类别码
		echo "<div style='height:300px;width:60%;margin:auto'><table border='1' cellpadding='10'>";
		echo "<tr>";
		for($i=0;$i<count($token);$i++){
			if($i%10==0) echo "</tr><tr>";	//每10个位一列
			echo "<td align:left; width='30px'>".$token[$i]."</td><td align:left; width='30px'>".check_table($token[$i])."</td>";
		}
		//



		var_dump($token);echo "<br>";

		//语法分析器的LL(1)文法实现
		
		function check_analytable($now_stack_char,$now_char){
			$analy_table=array(
			"E"=>array("I"=>1,"("=>1),
			"E1"=>array("w0"=>2,")"=>3,"#"=>3),
			"T"=>array("I"=>4,"("=>4),
			"T1"=>array("w0"=>6,"w1"=>5,")"=>6,"#"=>6),
			"F"=>array("I"=>7,"("=>8)
			);
			echo $now_stack_char." ".$now_char;
			return $analy_table[$now_stack_char][$now_char];
		}
		function is_Vt($stack_top){  //判断是否是终结符
			if($stack_top=="w1"||$stack_top=="w0"||$stack_top=="I"
				||$stack_top=="("||$stack_top==")") return true;
			else
				return false;
		}
		function return_state($now_char){
			if($now_char=="+"||$now_char=="-") return w0;
			elseif($now_char=="*"||$now_char=="/") return w1;
			elseif($now_char=="(") return '(';
			elseif($now_char==")") return ')';
			elseif($now_char=="#") return '#';
			else return I;
		}

		$G=array(
			'1'=>array("E","->","T","E1"),
			'2'=>array("E1","->","w0","T","E1"),
			'3'=>array("E1","->"),
			'4'=>array("T","->","F","T1"),
			'5'=>array("T1","->","w1","F","T1"),
			'6'=>array("T1","->"),
			'7'=>array("F","->","I"),
			'8'=>array("F","->","(","E",")")
			);
		$i=0;
		$result=1;//结果为1，如果没有错误，一直为1
		$stack=array("#");
		$stack[]="E";
		next_char:	
			$now_char=$token[$i];
		pop:
			$stack=array_values($stack);
			$length=count($stack);
			$stack_top=$stack[$length-1];//echo "the top is $stack_top<br>";
			//var_dump($stack);echo "<br>";
			unset($stack[$length-1]);
			$stack=array_values($stack);
			
			if(is_Vt($stack_top)){ 

				//if(return_state($now_char)!=$stack_top) {
				echo return_state($now_char)."与".$stack_top."归约<br>";
				if(strcmp(return_state($now_char),$stack_top)!=0){
					echo "error<br>";
					goto end_error;
				}
				else{
					$i++;
					echo "success<br>";
					goto next_char;
				}
			}
			//elseif($stack_top=="#"){
			elseif($now_char=="#"){
				goto end;
			}
			else{
				$sentence=check_analytable($stack_top,return_state($now_char)); //查询语句的状态
				echo " after check analytable".$sentence."<br>";
				if ($sentence=="") {
					echo "error<br>";
					goto end_error;
				}
				else{

					for($j=count($G[$sentence])-1;$j>1;$j--){
						$stack=array_values($stack);
						$stack[]=$G[$sentence][$j];
					}
				}
				goto pop;
			}

		end_error:$result=0;echo "wrong<br>";
		end:
		if($result==1)echo "result:right<br>";




		//递归子程序法
		function nextw(){
			$GLOBALS['i']++;echo $GLOBALS['i']." ";
			global $token;
			$GLOBALS['now_char']=return_state($token[$GLOBALS['i']]);
			$i=$GLOBALS['i'];
			echo "读入".$GLOBALS['now_char']."<br>";
		}
		function E(){
			echo "调用E<br>";
			T();
			loop_T:
			if($GLOBALS['now_char']=="w0"){
				nextw();
				T();
				goto loop_T;
			}
		}

		function T(){
			echo "调用T<br>";
			F();
			loop_F:
			if($GLOBALS['now_char']=="w1"){
				nextw();
				F();
				goto loop_F;
			}
		}

		function F(){
			echo "调用F<br>";
			if($GLOBALS['now_char']=="I"){
				nextw();
			}
			elseif($GLOBALS['now_char']=="("){
				nextw();
				E();
				if($GLOBALS['now_char']==")"){
					nextw();
				}
				else{
					$GLOBALS['result']=0;
					echo "err2";
				}
			}
			else{
				$GLOBALS['result']=0;
				echo "err1";
			}
		}
		//主程序开始
		echo "<br><br>使用递归下降子程序：<br>";
		$GLOBALS['result']=1;
		$GLOBALS['i']=0;
		$GLOBALS['now_char']=return_state($token[$GLOBALS['i']]);
		echo $GLOBALS['i']." ";
		echo "读入".$GLOBALS['now_char']."<br>";
		E();
		if($GLOBALS['now_char']!="#") {
			$GLOBALS['result']=0;
		}
		re_true_ending:
			if($GLOBALS['result']==1) echo "result:right";
			else{
				echo "wrong";
			}






		//
	/*	function GEQ($str){
			global $stack,$t,$QT;
			$QT[]=$str;
			$length=count($stack);
			$QT[]=$stack[$length-2];
			$QT[]=$stack[$length-1];
			$QT[]="t$t";
			
			unset($stack[$length-2]);
			unset($stack[$length-1]);
			$stack=array_values($stack);
			$stack[]="t$t";
			$t++;
		}
		function nextw(){
			$GLOBALS['i']++;echo $GLOBALS['i']." ";
			global $token;
			$GLOBALS['now_char']=$token[$GLOBALS['i']];
			$i=$GLOBALS['i'];
			echo "读入".$GLOBALS['now_char']."<br>";
		}
		function E(){
			global $QT,$t;
			global $stack;
			//echo "调用E<br>";
			T();
			loop_T:
			if($GLOBALS['now_char']=="+"){
				nextw();
				T();
				echo "+ ";
				$sign[]="+";
				GEQ("+");
				goto loop_T;
			}
			elseif($GLOBALS['now_char']=="-"){
				nextw();
				T();
				GEQ("-");
				goto loop_T;
			}
		}

		function T(){
			//echo "调用T<br>";
			F();
			loop_F:
			if($GLOBALS['now_char']=="*"){
				nextw();
				F();
				//echo "* ";
				GEQ("*");
				goto loop_F;
			}
			elseif($GLOBALS['now_char']=="/"){
				nextw();
				F();
				GEQ("/");
				goto loop_F;
			}
		}

		function F(){
			global $stack;
			//echo "调用F<br>";
			if(is_numeric($GLOBALS['now_char'])||($GLOBALS['now_char']>='a'&&
				$GLOBALS['now_char']<='z')){
				$stack[]=$GLOBALS['now_char'];
				nextw();
			}
			elseif($GLOBALS['now_char']=="("){
				nextw();
				E();
				if($GLOBALS['now_char']==")"){
					nextw();
				}
				else{
					$GLOBALS['result']=0;
					echo "err2";
				}
			}
			else{
				$GLOBALS['result']=0;
				echo "err1";
			}
		}
		//主程序开始
		//echo "<br><br>使用递归下降子程序：<br>";
		$GLOBALS['result']=1;
		$GLOBALS['i']=0;
		$stack=array();
		$sign=array();
		$QT=array();
		$t=1;
		$GLOBALS['now_char']=$token[$GLOBALS['i']];
		//echo $GLOBALS['i']." ";
		echo "读入".$GLOBALS['now_char']."<br>";
		E();
		if($GLOBALS['now_char']!="#") {
			$GLOBALS['result']=0;
		}
		re_true_ending:
			if($GLOBALS['result']==1) echo "right";
			else{
				echo "wrong";
			}

		echo "<br>四元式为：<br>";		
		$length=count($QT);
		for($i=0;$i<$length;$i++){
			if($i%4==0&&$i!=0)
				echo "<br>";
			echo $QT[$i]." ";
		}
		*/
}