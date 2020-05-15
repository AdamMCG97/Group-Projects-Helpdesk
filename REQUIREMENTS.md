# REQUIREMENTS

* The system must be able to handle both hardware and software issues.
* Every different problem needs a unique problem number, even if more than one problem is reported in the same call.
* Every call is to be logged even if it relates to an existing problem.
* The system should assign each issue to the relevant specialist.
* The system should show how many tasks are currently assigned to each specialist.

# INFORMATION RECORDED (NEW ISSUE)

* Caller name
* Operator name
* Time of call
* Serial number (if hardware)
* Operating system and software (if software)
* Problem number 
* Problem type
* Call type (new issue / follow-up)

# INFORMATION RECORDED (RESOLVED ISSUE)

* Date and time of resolution
* Indication of how the problem was resolved
* Name of the person who provided the solution

# DATABASES

* Personnel
	* Name
	* ID number
	* Job title
	* Department
	* Telephone

* Equipment
	* Serial number
	* Type
	* Make

* Authorised software

# TODO:
* Logout button (done)
* Take current user from login page (done)
* Problem type dropdown with refinements
* Do some themeing
* Add resolution details to view ticket (done)