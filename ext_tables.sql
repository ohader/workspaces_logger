#
# Table structure for table 'tx_workspaceslogger_event'
#
CREATE TABLE tx_workspaceslogger_event (
	uid int(11) NOT NULL auto_increment,

	eventtype int(11) DEFAULT '0' NOT NULL,
	eventuid int(11) DEFAULT '0' NOT NULL,
	eventtable varchar(255) DEFAULT '' NOT NULL,
	valueinteger int(11) DEFAULT '0' NOT NULL,
	valuestring varchar(255) DEFAULT '' NOT NULL,

	PRIMARY KEY (uid)
);

