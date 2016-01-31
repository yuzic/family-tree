<?php if (!empty($notify['error'])) {
	echo $notify['error'];
}
?>
<?='[' . implode(',', $treeList) .']';  