<?php

$string['addcohort'] = 'Add new Section';
$string['allcohorts'] = 'All Sections';
$string['anycohort'] = 'Any';
$string['assign'] = 'Assign';
$string['assignto'] = 'Cohort \'{$a}\' members';
$string['backtocohorts'] = 'Back to Sections';
$string['bulkadd'] = 'Add to section';
$string['bulknocohort'] = 'No available sections found';
$string['categorynotfound'] = 'Category <b>{$a}</b> not found or you don\'t have permission to create a section there. The default context will be used.';
$string['cohort'] = 'Section';
$string['cohorts'] = 'Sections';
$string['cohortsin'] = '{$a}: available sections';
$string['assigncohorts'] = 'Assign section members';
$string['component'] = 'Source';
$string['contextnotfound'] = 'Context <b>{$a}</b> not found or you don\'t have permission to create a section there. The default context will be used.';
$string['csvcontainserrors'] = 'Errors were found in CSV data. See details below.';
$string['csvcontainswarnings'] = 'Warnings were found in CSV data. See details below.';
$string['csvextracolumns'] = 'Column(s) <b>{$a}</b> will be ignored.';
$string['currentusers'] = 'Current users';
$string['currentusersmatching'] = 'Current users matching';
$string['defaultcontext'] = 'Default context';
$string['delcohort'] = 'Delete section';
$string['delconfirm'] = 'Do you really want to delete section \'{$a}\'?';
$string['description'] = 'Description';
$string['displayedrows'] = '{$a->displayed} rows displayed out of {$a->total}.';
$string['duplicateidnumber'] = 'Section with the same ID number already exists';
$string['editcohort'] = 'Edit section';
$string['editcohortidnumber'] = 'Edit section ID';
$string['editcohortname'] = 'Edit section name';
$string['eventcohortcreated'] = 'Section created';
$string['eventcohortdeleted'] = 'Section deleted';
$string['eventcohortmemberadded'] = 'User added to a Section';
$string['eventcohortmemberremoved'] = 'User removed from a section';
$string['eventcohortupdated'] = 'Section updated';
$string['external'] = 'External section';
$string['invalidtheme'] = 'Section theme does not exist';
$string['idnumber'] = 'Section ID';
$string['memberscount'] = 'Section size';
$string['name'] = 'Name';
$string['namecolumnmissing'] = 'There is something wrong with the format of the CSV file. Please check that it includes the correct column names. To add users to a cohort, go to \'Upload users\' in the Site administration.';
$string['namefieldempty'] = 'Field name can not be empty';
$string['newnamefor'] = 'New name for section {$a}';
$string['newidnumberfor'] = 'New ID number for section {$a}';
$string['nocomponent'] = 'Created manually';
$string['potusers'] = 'Potential users';
$string['potusersmatching'] = 'Potential matching users';
$string['preview'] = 'Preview';
$string['privacy:metadata:cohort_members'] = 'Information about the user\'s section.';
$string['privacy:metadata:cohort_members:cohortid'] = 'The ID of the section';
$string['privacy:metadata:cohort_members:timeadded'] = 'The timestamp indicating when the user was added to the section';
$string['privacy:metadata:cohort_members:userid'] = 'The ID of the user which is associated to the section';
$string['removeuserwarning'] = 'Removing users from a section may result in unenrolling of users from multiple courses which includes deleting of user settings, grades, group membership and other user information from affected courses.';
$string['selectfromcohort'] = 'Select members from section';
$string['systemcohorts'] = 'System sections';
$string['unknowncohort'] = 'Unknown section ({$a})!';
$string['uploadcohorts'] = 'Upload sections';
$string['uploadedcohorts'] = 'Uploaded {$a} sections';
$string['useradded'] = 'User added to section "{$a}"';
$string['search'] = 'Search';
$string['searchcohort'] = 'Search section';
$string['uploadcohorts_help'] = 'Section may be uploaded via text file. The format of the file should be as follows:

* Each line of the file contains one record
* Each record is a series of data separated by commas (or other delimiters)
* The first record contains a list of fieldnames defining the format of the rest of the file
* Required fieldname is name
* Optional fieldnames are idnumber, description, descriptionformat, visible, context, category, category_id, category_idnumber, category_path
';
$string['visible'] = 'Visible';
$string['visible_help'] = "Any section can be viewed by users who have 'moodle/cohort:view' capability in the cohort context.<br/>
Visible section can also be viewed by users in the underlying courses.";
