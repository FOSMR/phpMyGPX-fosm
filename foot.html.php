
<hr width="100%" color="#0000FF" size="3">

<table width=100%><tr>
<td width=33%>
<a href="Javascript:window.scrollTo(0,0)" title="<?php echo _CMN_TOP; ?>"><img hspace="5" src="<?php echo _PATH; ?>images/up.png" width="13" height="8" border="0" alt="top"></a>
</td>
<td width=33%>
<div align="center">
<font size="-1"><i>powered by <a href="http://phpmygpx.tuxfamily.org/"><?php echo _APP_NAME." "._APP_VERSION; ?></a></i></font>
</div>
</td>
<td align="right">
<?php
if($cfg['show_exec_time'] && isset($exectime))
	echo "<span id='exectime'> ["._CMN_SCRIPT_EXEC_TIME." $exectime sec]</span>";
?>
</td>
</tr></table>

</div>
</body>
</html>