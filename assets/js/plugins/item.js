(function() {
  tinymce.PluginManager.add('owls_item', function(editor, url) {
    editor.addButton('owls_item', {
      tooltip: 'Owls Carousel Item',
      icon: 'owls-item',
      onclick: function() {
        editor.insertContent('[owls_item]Insert your owl item content here...[/owls_item]');
      }
    });
  });
})();
