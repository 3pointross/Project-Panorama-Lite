(function() {
    tinymce.create('tinymce.plugins.pspButtons', {

          init : function(ed, url) {
                            
                ed.addButton('currentprojects', {
                    title : 'Project List',
                    cmd : 'activeprojects',
                    image : url + '/active-projects.png'
                });
                 
                ed.addCommand('activeprojects', function() {
			    	tb_show('Insert a List of Projects','#TB_inline?width=480&inlineId=psp-project-listing-dialog&width=640&height=597');
                });

                ed.addButton('singleproject', {
                    title : 'Embed a Project',
                    cmd : 'displayproject',
                    image : url + '/single-project.png'
                });
                
                ed.addCommand('displayproject', function() {
					PopulatePspSingleShortcode();
					tb_show('Insert a Project','#TB_inline?width=480&inlineId=psp-single-project-diaglog&width=640&height=597');
                });
             },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'PSP Buttons',
                author : '37 Media',
                authorurl : 'http://37mediallc.com',
                infourl : 'http://37mediallc.com',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'pspbuttons', tinymce.plugins.pspButtons );
})();