(function() {
  tinymce.PluginManager.add('owls_wrapper', function(editor, url) {
    editor.addButton('owls_wrapper', {
      tooltip: 'Owl Carousel Wrapper',
      icon: 'owls-wrapper',
      onclick: function() {
        // Open window
        editor.windowManager.open({
          title: 'Owl Carousel Wrapper',
          body: [{
            type: 'textbox',
            name: 'itemnum',
            value: '5',
            label: 'Number of items'
          },{
            type: 'checkbox',
            name: 'iscentered',
            checked: false,
            label: 'Is Centered?'
          },{
            type: 'checkbox',
            name: 'isrtl',
            checked: true,
            label: 'Is RTL?'
          }],
          onsubmit: function(e) {
            // Insert content when the window form is submitted
            var uID = guid();
            var shortcode = '[owls_wrapper num="'+ e.data.itemnum +'" centered="'+ e.data.iscentered +'" rtl="'+ e.data.isrtl +'" id="owl_wrapper_' + uID + '"]<br class="nc"/>[/owls_wrapper]';
            editor.insertContent(shortcode);
          }
        });
      }
    });
  });

  function guid() {
      function s4() {
          return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
      }
      return s4() + '-' + s4();
  }
})();
