These are the release notes for Moodle Direct V2 which contains a new Turnitin Assignment tool, a Plagiarism plugin and a block to allow access to the new Class Migration Tool.

For installation instructions and trouble shooting please see Installation Instructions.txt and Troubleshooting.txt or the relevant README files within each individual plugin element.

Moodle Direct v2 Release Notes
------------------------------------------------------------------------------------

####################################################################################

Date:       2014-November-17
Release:    v2014012410

- Cron scores update in the Plagiarism plugin are now split by submission type.
- Fixes:
	> Anonymous marking reveal form fixed and now initialises correctly on inbox load.
	> Incorrect repository value fixed when synching assignments in Plagiarism plugin.
	> Assignment title length check added on Turnitin assignments.
	> Resubmission grade warning no longer shown when resubmission is not possible.
	> Post date stored correctly for PP assignment (thanks to Michael Aherne).
	> Post dates not updated for future PP assignments.

####################################################################################

Date:       2014-October-08
Release:    v2014012409

- Czech language pack added.
- Plagiarism plugin now uses the hidden until date from gradebook as the post date on Turnitin.
- PP Post date in Turnitin is now stored in Moodle.
- Connection test added to cron event handler.
- Unnecessary Gradebook update removed when viewing Turnitin Assignment.
- Specify assign when looking for user's grades in PP (Thanks to mattgibson).
- PHP end tags removed to fit with moodle guidelines.
- PHP header function replaced with moodle redirect function to fit with moodle guidelines.
- Error handling added when getting users for tutors and students tabs.
- Error handling added when enrolling all students in tutors and students tabs.
- Submissions are removed from the events cron if a student has not accepted the EULA.
- EULA is now presented via an Iframe rather than a separate tab.
- Late submissions allowed setting in Turnitin for Plagiarism plugin assignments is now always true.
- Fixes:
	> Details for a non moodle user who is only in expired classes can be retrieved when grabbing submission data.
	> Logger class renamed in SDK.
	> Gradelib file included in cron.
	> Scope of tool tipster anti-aliasing fixed to not affect whole of Moodle.
	> Date of late submissions indicated in red.
	> Oracle database error when getting forum post.
	> Inbox hidden columns fixed if Grademark is disabled.
	> Individual part post dates can now be the same as post date.
	> Submissiontype now used in correct context in PP file errors.
	> Test connection now hidden on plugin upgrade.
	> Incorrect word count on text content submissions fixed.
	> Moodle assignment due dates now advanced by 1 day in Turnitin instead of 1 month.
	> Select all checkbox fixed in Unlink users screen.
	> Editable date boxes now re-enable after esc is pressed while one is active.
	> Document viewer no longer hangs in Safari and is no longer blocked by popups.
	> Student can delete a submission that hasn’t gone to Turnitin in a Turnitin assignment.

####################################################################################

Date:       2014-September-22
Release:    v2014012408

- Fixes:
	> EULA notice removed from PP submissions with previous submissions.
	> Rubrics now being saved in PP.
	> EULA no longer blocked by popups in Turnitin Assignment.
	> EULA & Disclosure no longer being shown if PP is disabled for module (Thanks to Dan Marsden).

####################################################################################

Date:       2014-September-04
Release:    v2014012407

- Remove Grademark settings if GradeMark is disabled. (Thanks to Alex Rowe)
- Date handling reconfigured in PP to prevent erros (Thanks to Dan Marsden)
- Fixes:
	> File errors page no longer errors if file has been deleted. (Thanks to Ruslin Kabalin)
	> Course migration bug no longer tries to populate PP array in migration if PP not installed.
	> Inbox submission links now work after refreshing non moodle users submissions in Turnitin Assignment.
	> Assignment Grade (PP) table no longer populated if grade is null when cron runs.
	> Encoding issue with module description fixed.
	> Anonymous marking no longer set if not enabled in settings (Thanks to Dan Marsden).

####################################################################################

Date:       2014-August-19
Release:    v2014012406

- Error reporting added for files that are too large, small submissions and any other submission errors.
- Error reporting added to cron.
- Error reporting and success statement added at submission stage.
- Non acceptance of EULA now indicated to tutor in inbox.
- Error indicators and rollover messages now displayed in inbox.
- Error messages saved and displayed in settings area.
- EULA moved to submission declaration and submission form hidden.
- Turnitin Paper Id now shown next to submission to show that paper has been submitted. 
- Fixes:
	> Long assignment titles are now truncated.
	> Link to a file in Assignment Summary now renders correctly.
	> Inbox part date editing now works on Windows servers.
	> Cron in PP changed to check for scores when ORcapable is 1.
	> Course Migration query fixed when creating class.
	> Course migration error fixed when no Turnitin courses to link to exist.

####################################################################################

Date:       2014-June-11
Release:    v2014012405

- Course reset functionality added to remove Turnitin data when a class/module is reset.
- Ability added to enable/disable Turnitin in individual modules.
- Ability added for instructors to refresh individual rows in a Turnitin Assignment.
- Automatic grade refreshing from Turnitin can now be turned off in Turnitin Assignments.
- Anonymous marking and Translated matching settings removed in PP modules if they are disabled in config.
- Config warning added if plugin has not been configured.
- Anonymous marking option is locked once a submission is made to any assignment part.
- Font Awesome added to plugin
- EULA closing reworked to accomodate IE
- Javascript cleaned up in block to use Moodle value (Thanks to Skylar Kelty).
- Version file updated for Moodle 2.7+ compatibility (Thanks to Skylar Kelty).
- Javascript reorganised to fit better with Moodle guidelines
- Erroneous debugging removed (Thanks to Skylar Kelty).
- Check for XMLWriter extension added to settings area.
- Removed restriction on word count and content length if accepting any file type in PP.
- Removed restriction in PP to allow submissions after the due date.
- Automatic connection test and upgrade check in settings stopped and changed to buttons.
- User creation removed from restore procedure.
- Additonal indexes added to database tables
- Extra permission checks added for migration tool
- Error message now shown if ajax request to get submissions times out 
- Improved CSS to scope only to plugins and files added to jQuery plugin organisation
- Forum posts are now submitted to Turnitin when posted
- Database dump added to PP settings page
- WSDL files used by SDK are now stored locally.
- SDK setting added to use Moodle SSL certificate if it is present.
- Code changes as required by Moodlerooms to better fit Moodle guidelines
- Fixes:
	> User could submit to Turnitin Assignment without accepting Moodle disclaimer
	> Postgres type error when searching unlinked users query
	> A grade set to 0 in GradeMark was showing as — in Turnitin Assignment
	> Allow Non OR file type setting now being changed in Turnitin
	> New file submissions with same filename display correct OR link in PP.
	> Peermark Manager now accessible to any instructor in PP
	> Turnitin Messages Inbox now accessible to any instructor
	> Gradebook now updates when post date is changed on the inbox screen.
	> Grademark null grades no longer overwrite grades previously set in Moodle via PP.
	> Accept anything setting is now passed to recreated assignment in Course migration
	> Feedback files no longer sent to Turnitin in PP
	> Admin now enrolled on class when migrating incase they are not on the account.
	> PP cron now ignores files with no OR score when cron attempts to refresh scores.
	> Grades now removed from Gradebook when submission is deleted.

####################################################################################

Date:       2014-June-11
Release:    v2014012404

- EULA acceptance is now stored locally for submissions.

####################################################################################

Date:       2014-April-17
Release:    v2014012403

- Grademark link removed for student if a grade has not been set in Plagiarism Plugin.
- Feedback release date changed on forum with plagiarism plugin to be the same as start date.
- Infinite loading of Document viewer stopped.
- Full Catalan language pack added.
- Submissions in Plagiarism plugin stopped if there has been 5 unsuccessful attempts.
- Link removed for Originality Report if there is no score.
- Fixes:
	> Incorrect links to GradeMark and Originality Report for students have been hidden. 
	> Conflicts with Bootstrap theme for tooltips and fixed grademark link position.
	> Incorrect settings link in the Plagiarism plugin.
	> Timestamp was being incorrectly set preventing more than 1 batch of submissions updating from Turnitin. 
	> Student is now enrolled on the class when checking EULA acceptance to ensure they are on account.

####################################################################################

Date:       2014-February-26
Release:    v2014012402

- Vietnamese Language pack added.
- Option to send draft submissions to Turnitin in Plagiarism Plugin reinstated.
- Diagnostic mode reinstated to disable logging by default.
- Troubleshooting documentation expanded.
- Fixes:
	> Student’s who’d never submitted could not view rubric, they’re now enrolled at this point.
	> Instructor now being enrolled in course when resetting to prevent errors in reading memberships.
	> OR Link was being shown in Plagiarism Plugin for non OR submissions.
	> Submissions now processed in Plagiarism Plugin if due date disabled.
	> Rubric List was not being populated in Plagiarism Plugin settings.
	> Updating of OR scores depending on OR submissions capability fixed in Plagiarism Plugin.
	> Cut off date / late submission issues solved in Plagiarism Plugin (Thanks to Chris Wharton).
	> Generic CSS issues fixed that were breaking some user’s themes.
	> Timezone was not being accounted for when editing part dates in inbox.
	> Editing title in course context is now updated in Turnitin.
	> Submit nothing link removed if submission has been made to Moodle but not yet processed by Turnitin
	> Incorrect grade scale calculation.
	> Previous Turnitin users were not being joined to account on Plagiarism plugin.

####################################################################################

Date:       2014-January-24
Release:    v2014012401

- File type limit removed.
- Ability to accept no file added so that marks / grades can be allocated to non file submissions 
- Dependencies added to plagiarism plugin and blocks
- Fixes:
	> Error occurring in course reset 

####################################################################################
Date: 		2013-December-18
Release:	v2013121801

- Supports Turnitin Originality Checking, GradeMark and PeerMark
- Allows access to the Rubric Manager and Quickmark Manager from within the Moodle environment
- Supports multi-part assignments allowing draft and revision submissions
- Allows instructors to submit work on behalf of students
- Supports Moodle Grade Scales and updates the Moodle gradebook with grades entered in GradeMark
- Supports Moodle Groups
- Allows multiple instructors to access a class and assignments in Turnitin’s web interface
- Supports Moodle’s built-in plagiarism detection thereby allowing access to Turnitin functionality from within Moodle assignments
- Incorporates a Class Migration feature allowing access to classes and assignments that are in Turnitin but not in the Moodle environment

