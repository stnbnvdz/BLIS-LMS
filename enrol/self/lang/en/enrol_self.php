<?php


$string['canntenrol'] = 'Enrollment is disabled or inactive';
$string['canntenrolearly'] = 'You cannot enroll yet; enrollment starts on {$a}.';
$string['canntenrollate'] = 'You cannot enroll any more, since enrollment ended on {$a}.';
$string['cohortnonmemberinfo'] = 'Only members of section \'{$a}\' can self-enrol.';
$string['cohortonly'] = 'Only section members';
$string['cohortonly_help'] = 'Self enrollment may be restricted to members of a specified cohort only. Note that changing this setting has no effect on existing enrollments.';
$string['confirmbulkdeleteenrolment'] = 'Are you sure you want to delete these user enrollments?';
$string['customwelcomemessage'] = 'Custom welcome message';
$string['customwelcomemessage_help'] = 'A custom welcome message may be added as plain text or Moodle-auto format, including HTML tags and multi-lang tags.

The following placeholders may be included in the message:

* Course name {$a->coursename}
* Link to user\'s profile page {$a->profileurl}
* User email {$a->email}
* User fullname {$a->fullname}';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during self enrollment';
$string['deleteselectedusers'] = 'Delete selected user enrollments';
$string['editselectedusers'] = 'Edit selected user enrollments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can enrol themselves until this date only.';
$string['enrolenddaterror'] = 'Enrollment end date cannot be earlier than start date';
$string['enrolme'] = 'Enroll me';
$string['enrolperiod'] = 'Enrollment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrollment is valid. If set to zero, the enrollment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrollment is valid, starting with the moment the user enrols themselves. If disabled, the enrollment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can enrol themselves from this date onward only.';
$string['expiredaction'] = 'Enrollment expiry action';
$string['expiredaction_help'] = 'Select action to carry out when user enrollment expires. Please note that some user data and settings are purged from course during course unenrollment.';
$string['expirymessageenrollersubject'] = 'Self enrollment expiry notification';
$string['expirymessageenrollerbody'] = 'Self enrollment in the course \'{$a->course}\' will expire within the next {$a->threshold} for the following users:

{$a->users}

To extend their enrollment, go to {$a->extendurl}';
$string['expirymessageenrolledsubject'] = 'Self enrollment expiry notification';
$string['expirymessageenrolledbody'] = 'Dear {$a->user},

This is a notification that your enrollment in the course \'{$a->course}\' is due to expire on {$a->timeend}.

If you need help, please contact {$a->enroller}.';
$string['expirynotifyall'] = 'Teacher and enrolled user';
$string['expirynotifyenroller'] = 'Teacher only';
$string['groupkey'] = 'Use group enrollment keys';
$string['groupkey_desc'] = 'Use group enrollment keys by default.';
$string['groupkey_help'] = 'In addition to restricting access to the course to only those who know the key, use of group enrollment keys means users are automatically added to groups when they enrol in the course.

Note: An enrollment key for the course must be specified in the self enrollment settings as well as group enrollment keys in the group settings.';
$string['keyholder'] = 'You should have received this enrollment key from:';
$string['longtimenosee'] = 'Unenroll inactive after';
$string['longtimenosee_help'] = 'If users haven\'t accessed a course for a long time, then they are automatically unenrolled. This parameter specifies that time limit.';
$string['maxenrolled'] = 'Max enrolled users';
$string['maxenrolled_help'] = 'Specifies the maximum number of users that can self enrol. 0 means no limit.';
$string['maxenrolledreached'] = 'Maximum number of users allowed to self-enrol was already reached.';
$string['messageprovider:expiry_notification'] = 'Self enrollment expiry notifications';
$string['newenrols'] = 'Allow new enrollments';
$string['newenrols_desc'] = 'Allow users to self enroll into new courses by default.';
$string['newenrols_help'] = 'This setting determines whether a user can enrol into this course.';
$string['nopassword'] = 'No enrollment key required.';
$string['password'] = 'Enrollment key';
$string['password_help'] = 'An enrollment key enables access to the course to be restricted to only those who know the key.

If the field is left blank, any user may enroll in the course.

If an enrollment key is specified, any user attempting to enrol in the course will be required to supply the key. Note that a user only needs to supply the enrollment key ONCE, when they enrol in the course.';
$string['passwordinvalid'] = 'Incorrect enrollment key, please try again';
$string['passwordinvalidhint'] = 'That enrollment key was incorrect, please try again<br />
(Here\'s a hint - it starts with \'{$a}\')';
$string['pluginname'] = 'Self enrollment';
$string['pluginname_desc'] = 'The self enrollment plugin allows users to choose which courses they want to participate in. The courses may be protected by an enrollment key. Internally the enrollment is done via the manual enrollment plugin which has to be enabled in the same course.';
$string['requirepassword'] = 'Require enrollment key';
$string['requirepassword_desc'] = 'Require enrollment key in new courses and prevent removing of enrolment key from existing courses.';
$string['role'] = 'Default assigned role';
$string['self:config'] = 'Configure self enroll instances';
$string['self:holdkey'] = 'Appear as the self enrollment key holder';
$string['self:manage'] = 'Manage enrolled users';
$string['self:unenrol'] = 'Unenroll users from course';
$string['self:unenrolself'] = 'Unenroll self from the course';
$string['sendcoursewelcomemessage'] = 'Send course welcome message';
$string['sendcoursewelcomemessage_help'] = 'When a user self enrols in the course, they may be sent a welcome message email. If sent from the course contact (by default the teacher), and more than one user has this role, the email is sent from the first user to be assigned the role.';
$string['sendexpirynotificationstask'] = "Self enrollment send expiry notifications task";
$string['showhint'] = 'Show hint';
$string['showhint_desc'] = 'Show first letter of the guest access key.';
$string['status'] = 'Allow existing enrollments';
$string['status_desc'] = 'Enable self enrollment method in new courses.';
$string['status_help'] = 'If enabled together with \'Allow new enrollments\' disabled, only users who self enrolled previously can access the course. If disabled, this self enrollment method is effectively disabled, since all existing self enrollments are suspended and new users cannot self enrol.';
$string['syncenrolmentstask'] = 'Self enrollment synchronise enrollments task';
$string['unenrol'] = 'Unenroll user';
$string['unenrolselfconfirm'] = 'Do you really want to unenroll yourself from course "{$a}"?';
$string['unenroluser'] = 'Do you really want to unenroll "{$a->user}" from course "{$a->course}"?';
$string['unenrolusers'] = 'Unenroll users';
$string['usepasswordpolicy'] = 'Use password policy';
$string['usepasswordpolicy_desc'] = 'Use standard password policy for enrollment keys.';
$string['welcometocourse'] = 'Welcome to {$a}';
$string['welcometocoursetext'] = 'Welcome to {$a->coursename}!

If you have not done so already, you should edit your profile page so that we can learn more about you:

  {$a->profileurl}';
$string['privacy:metadata'] = 'The Self enrollment plugin does not store any personal data.';
