<?php

/**
 * 参数过滤
 * @author http://www.jb51.net/article/72175.htm
 * @date 2017-08-12
 * @return array
 */
function filterSafe($data = array()) {

    $ra=Array('/([\x00-\x08\x0b-\x0c\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
    foreach($data as $key=>$value){

        if(is_array($value)){
            filterSafe($value);//递归
        }else{
            
            if (!get_magic_quotes_gpc())             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
            {
                $value = addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
            }
            $value = preg_replace($ra,'',$value);     //过滤一切可疑字符
            $data[$key] = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
        }
    
    }

    return $data;
}

?>