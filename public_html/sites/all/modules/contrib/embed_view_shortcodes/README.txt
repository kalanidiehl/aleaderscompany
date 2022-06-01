Embed view shortcode is a module that allows users to embed view and block
content into node body and blocks using simple syntax using Shortcode api.

This module is really helpful When you want to allow users to embed views
or edit content on a page with an inserted view without granting them
permission to use PHP.

The syntax for embed view in multiple way are:

[view name="view name"][/view]
[view name="view name" display="display][/view]
[view name="view name" arg="argument"][/view]
[view name="view name" display="display name" arg="argument" ][/view]

The syntax for embed block is:[block id="block_id" ][/block].
The parameter is: block_id.

This Module provide the feature to the admin to handle the access
of the execution of shortcode by text format permission.

Example if user role has the permission of accessing the text format of HTML 
then the user will able to use this feature of embed shortcode view.

Installation:

1- Copy the whole "embed_view_shortcodes" directory to your modules
2- Enable the module.

Requirement:

1- Shortcode

Configuration:
1- Go to the admin/config/content/formats
2- Confiure the text format
3- Check the Shortcode Option
4- Enable Embed View Data shortcode option for using view shortcode
5- Enable Embed Block Data shortcode option for using block shortcode

Similar modules:

Insert View
Insert Block
