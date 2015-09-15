<?php
function ahref($path, $name = "><", $atts = "") {
	if ($name == "><") {
		$name = $path;
	}
	return '<a '.$atts.' href="'.$path.'">'.$name.'</a>';
}

function img($src, $attrs = "") {
	return '<img border="0" '.$attrs.' src="'.$src.'">';
}

function fontncss($s, $a = "") {
	return '<font style="'.$a.'">'.$s.'</font>';
}

function font($s, $c = "", $size = 0) {
	if ($size == 0) {
		return '<font class="'.$c.'">'.$s.'</font>';
	} else {
		return '<font class="'.$c.'" style="font-size: '.$size.'px;">'.$s.'</font>';
	}
}

function htmlalign($s, $m) {
	return '<div align="'.$m.'"> '.$s.' </div>';
}

function center($s) {
	return htmlalign($s, "center");
}

function b($s) {
	return "<b> $s </b>";
}

function pre($s) {
	return "<pre>".$s."</pre>";
}

function span($s, $a = "") {
	return "<span $a>".$s."</span>";
}

function div($s, $a = "") {
	return "<div $a>".$s."</div>";
}

function margin1px() {
	return div('', ' style="height:1px;" ');
};

function tinymargin() {
	return div('', ' class="tinymargin" ');
};

function smallmargin() {
	return div('', ' class="smallmargin" ');
};

function topmargin() {
	return div('', ' class="topmargin" ');
};

function bottommargin() {
	return div('', ' class="bottommargin" ');
};

function td($s = " ", $a = null) {
	if (gettype($s) == "array") {
		$ret = "";
		foreach ($s as $k => $v) {
			if ($a != null) {
				$ret .= td($v, $a[$k]);
			} else {
				$ret .= td($v);
			}
		}
		return $ret;
	} else {
		return (" <td $a>".$s."</td> ");
	}
}

function tr($s, $a = null) {
	return ("<tr>".td($s, $a)."</tr>");
}

function p($str, $options = '') {
	return ("<p $options>".$str."</p>");
}

function h1($str, $options = '') {
	return ("<h1 $options>".$str."</h1>");
}

function h2($str, $options = '') {
	return ("<h2 $options>".$str."</h2>");
}

function h3($str, $options = '') {
	return ("<h3 $options>".$str."</h3>");
}

function h4($str, $options = '') {
	return ("<h4 $options>".$str."</h4>");
}

function options($a, $selected = "", $va = "") {
	$re = "";
	$i = 0;
	if (gettype($va) == "array") {
		foreach ($a as $in => $el) {
			if ($i == $selected) {
				$re .= '<option value="'.$va[$i].'" selected>'.$el."</option>\n";
			} else {
				$re .= '<option value="'.$va[$i].'">'.$el."</option>\n";
			}
			$i ++;
		}
		return $re;
	}
	foreach ($a as $in => $el) {
		if ($i == $selected) {
			$re .= "<option selected value=\"$el\">".$el."</option>\n";
		} else {
			$re .= "<option value=\"$el\">".$el."</option>\n";
		}
		$i ++;
	}
	return $re;
}

function option($s, $selected = "") {
	if ($selected = "") {
		return ("<option>".$s."</option>\n");
	} else {
		return ("<option ".$selected." >".$s."</option>\n");
	}
}

function selecthtml($name, $size, $options, $class = "no-class-") {
	$ret = "\n<select name=\"$name\" size=\"$size\">";
	$i = 0;
	if (gettype($options) == "array") {
		while (list ($k, $v) = each($options)) {
			if (!$i)
				$sele = "selected";
			else
				$sele = "";
			$ret .= option($v, $sele);
			$i ++;
		}
	} else {
		$ret .= option($options, "selected");
	}
	return ($ret."</select>\n");
}

function input($name, $value, $text, $type = "text", $extra = "", $textleft = 1, $class = "no-class-") {
	if ($textleft) {
		if ($name == "") {
			return ("<input type=\"$type\" value=\"$value\" $extra class=\"$class\">".$text."\n");
		} else {
			return ("<input type=\"$type\" name=\"$name\" $extra value=\"$value\" class=\"$class\">".$text."\n");
		}
	} else {
		if ($name == "") {
			return ($text."<input type=\"$type\" value=\"$value\" $extra class=\"$class\">\n");
		} else {
			return ($text."<input type=\"$type\" name=\"$name\" $extra value=\"$value\" class=\"$class\">\n");
		}
	}
}

function submit($value, $extra = "", $class = "no-class-") {
	return input("", $value, "", "submit");
}

function resethtml($value, $class = "no-class-") {
	return input("", $value, "", "reset");
}

function form($name, $action, $elements, $method = "post", $class = "no-class-") {
	return ("<form name=\"$name\" action=\"$action\" method=\"$method\" class=\"$class\">\n".$elements."</form>\n");
}

function back($descr='Cofnij', $ile=-1) {
	return '<a href="javascript: history.go(' . $ile . ')">' . $descr . '</a>';	
}
?>