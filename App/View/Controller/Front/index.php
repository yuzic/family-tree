<!DOCTYPE html>
<html>
<head>
	<title>Add / Delete items</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/codebase/dhtmlxtree.css"/>
	<script src="/codebase/dhtmlxtree.js"></script>
	<script>
		var myTree;
		function doOnLoad(){
			myTree = new dhtmlXTreeObject("treeboxbox_tree","100%","100%",0);
			myTree.setImagePath("/codebase/imgs/dhxtree_skyblue/");
			var data = {};
                $.ajax('/tree/lists', {
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                       myTree.parse(data, "jsarray");
                    },
                    error: function() {
                        console.log('failed to get list from directory');
                    }
                });

		}
		function fixImage(id){
			switch(myTree.getLevel(id)){
			case 1:
				myTree.setItemImage2(id,'folderClosed.gif','folderOpen.gif','folderClosed.gif');
				break;
			case 2:
				myTree.setItemImage2(id,'folderClosed.gif','folderOpen.gif','folderClosed.gif');
				break;
			case 3:
				myTree.setItemImage2(id,'folderClosed.gif','folderOpen.gif','folderClosed.gif');
				break;
			default:
				myTree.setItemImage2(id,'leaf.gif','folderClosed.gif','folderOpen.gif');
				break;
			}
		}

		function addItem()
		{
			var d=new Date();
			var selectItem = myTree.getSelectedItemId();
			var valueIntput = document.getElementById('ed1').value;

			if (selectItem == '') {
				alert("выберите семью!");
				return; 
			}

			if (valueIntput == '') {
				alert("введите название!");
				return; 
			}


			var data = {};
                data['parent_id'] = selectItem;
                data['name'] = valueIntput ;
                $.ajax('/tree/add', {
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        console.log(data);
						myTree.insertNewItem(selectItem,d.valueOf(),valueIntput,0,0,0,0,'SELECT'); 
						fixImage(d.valueOf());
                    },
                    error: function() {
                        console.log('error add item');
                    }
                });
	
		}


		function deleteItem()
		{

			var id = myTree.getSelectedItemId();

			console.log(id);

			if (id == 1) {
				alert("Нельзя удалить вселенную!");
				return ;
			}

			if (id == '') {
				alert("выберите семью!");
				return ;
			}

			var data = {};
                data['id'] = id ;
                $.ajax('/tree/delete', {
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {
                        myTree.deleteItem(myTree.getSelectedItemId(),true);
                    },
                    error: function() {
                        console.log('error add item');
                    }
                });
	
		}	
	</script>
</head>
<body onload="doOnLoad()">
	<h1>Редактор семей</h1>
	<table>
		<tr>
			<td valign="top">
				<div id="treeboxbox_tree" style="width:250px; height:218px;background-color:#f5f5f5;border :1px solid Silver; overflow:auto;"></div>
			</td>
				<td rowspan="2" style="padding-left:25px" valign="top">
				<a href="javascript:void(0);" onClick="addItem()">Добавить семью/человека</a> Имя семьи <input type="text" value="New item" id="ed1"><br><br>
				
				<a href="javascript:void(0);" onClick="deleteItem()">Удалить выбранную</a><br><br>
			</td>
		</tr>
	</table>

</body>
</html>