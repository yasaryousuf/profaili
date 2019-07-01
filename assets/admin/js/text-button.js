(function() {
	function get_menus(editor) {
		//console.log(editor);
		var metadatas = pfm_metadata.pfm_metadatas;
		metadatas.push = 'avatar';
		var menus = [];
		var ind = 0;

		for (var i in metadatas) {
			menus[ind] = {
				"text": metadatas[i],
				"value": metadatas[i],
				"onclick": function() {
					editor.insertContent("{{" + this.value() + "}}");
				}
			}
			ind++;
		}
		return menus;
	}

	tinymce.PluginManager.add('tc_button', function(editor, url) {
		editor.addButton('tc_button', {
			text: 'User Meta Data',
			title: 'Add User Meta Data',
			type: 'menubutton',
			menu: get_menus(editor)
		});
	});
})();