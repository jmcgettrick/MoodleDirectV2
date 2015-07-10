Moodle Direct v2
================

This collection of Moodle plugins is no longer updated. The folders have been split into separate repositories at:

- https://github.com/jmcgettrick/moodle-mod_turnitintooltwo
- https://github.com/jmcgettrick/moodle-plagiarism_turnitin
- https://github.com/jmcgettrick/moodle-block_turnitin

The code will remain here until our next release and we will endeavour to resolve currently open issues and pull requests. This page will remain but only as a pointer to the separate repositories.

--------------

Please be aware that the **Develop** branch should not be considered production ready and may contain bugs. It should be avoided in favor of the **Master** branch.

To see what has changed in recent versions of Moodle Direct V2, see the [CHANGELOG](https://github.com/jmcgettrick/MoodleDirectV2/blob/master/CHANGELOG.md).

If you would like to contribute to the plugin please see our [CONTRIBUTIONS](https://github.com/jmcgettrick/MoodleDirectV2/blob/master/CONTRIBUTIONS.md) page.

If you are having issues, please consult our [TROUBLE SHOOTING](https://github.com/jmcgettrick/MoodleDirectV2/blob/master/TROUBLESHOOTING.md) page.


Installation
------------

The Moodle direct version 2 package contains 3 folders for each respective plugin on Moodle. Each plugin requires that you are using Moodle 2.3 or higher. Before installing these plugins firstly make sure you are logged in as an Administrator.


### Module

The main plugin code is located in the zip file in **mod/turnitintooltwo** and is required by both of the other plugins to work. To install, all you need to do is copy the turnitintooltwo directory in to your moodle installations module directory /mod. You should then go to `"Site Administration" > "Notifications"` and follow the on screen instructions.

If you are using a pre 2.6 version of Moodle you will have to uncomment the initialising of $module in version.php before installing.

To configure the plugin go to `"Site Administration" > "Plugins" > "Activity Modules" > "Turnitin Assignment 2"` and enter your Turnitin account Id, shared key and API URL.

**Note:** *The URL is different for this package to previous Turnitin plugins. It should be https://api.turnitin.com, https://submit.ac.uk. or https://sandbox.turnitin.com.*


### Block

**Note:** *The turnitintooltwo module must be installed before you can use the turnitin block.*

The block plugin enables non-administrator moodle users to migrate courses from Turnitin to Moodle. To install, all you need to do is copy the /blocks/turnitin directory from the zip file in to your Moodle installations /blocks directory. You should then go to `"Site Administration" > "Notifications"` and follow the on screen instructions. 

Once the block is installed, it will need to be added to one or more of your Moodle screens. To do this you should switch Moodle to editing mode, in Moodle 2.6 this is done by clicking the "Turn editing on" button. Once the "Add a block" box is showing on screen select "Turnitin" and the block will be added to the screen. The block can be dragged around and positioned wherever you require.

If you have added a block and the logged-in user is enrolled on a class within your Turnitin account then a link will be displayed detailing how many classes a user has available to migrate. If the user has no courses available to migrate then the block will be hidden.


### Plagiarism Plugin

Note: the turnitintooltwo module must be installed before you can use the turnitin plagiarism plugin.

The Plagiarism Plugin can be used within the following Moodle modules:

- Assignments
- Forums
- Workshops

To install, you need to copy the plagiarism/turnitin directory from the zip file in to your Moodle installations /plagiarism directory and go to `"Site Administration" > "Notifications"` where you should follow the on screen instructions. 

Plagiarism plugins also need to be enabled before this plugin can be used. You can do this by going to `"Site Administration" > "Advanced Features"` and ticking the "Enable plagiarism plugins" box before saving. 

The Plagiarism Plugin will inherit connection settings from the turnitintooltwo module, but you can set default values and whether the plugin is enabled within Moodle modules by going to `"Site Administration" > "Plugins" > "Plagiarism prevention" > "Turnitin plagiarism plugin"`.

To create/update assignments, process submissions and update grades your moodle environment will need to have cron job running regularly. For information on how to do this please consult http://docs.moodle.org/26/en/Cron.
