-- echo ".read plist.sql" | sqlite3 plist.db

CREATE TABLE plist (
	id integer primary key autoincrement,
	title varchar(1280),
	artist varchar(1280),
	url varchar(1280),
	poster varchar(1280),
	rank integer,
	flag integer,
	dt timestamp NOT NULL default CURRENT_TIMESTAMP
);

