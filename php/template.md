## Php和 HTML的混合编写
* 深入学习，PHP如何解析文件，待续。。

```

<?php
/*********************************************************************
*   方式一
*********************************************************************/
$Items = [
	['room_id'=>1],
	['room_id'=>2],
	['room_id'=>3],

];
foreach ($Items as $item) {
    ?>
	<table>
		<tr>
			<td>
                <?php echo $item['room_id']; ?>
			</td>
		</tr>
	</table>

    <?php
}
?>



<?php
/*********************************************************************
*   方式二
*********************************************************************/
$Items = [
    ['room_id'=>1],
    ['room_id'=>2],
    ['room_id'=>3],

];
foreach ($Items as $item) {

	echo "
		<table>
		<tr>
			<td>
                {$item['room_id']}
			</td>
		</tr>
		</table>
	
	";
}

?>
```