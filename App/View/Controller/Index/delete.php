<?php if (!empty($notify['error'])) {
	echo json_encode($notify['error']);
}
if (!empty($notify['message'])) {
	echo json_encode(['message'	=> $notify['message']]);
}
?>