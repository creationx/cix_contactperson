#
# Table structure for table "tx_cix_contactperson_zip"
#
CREATE TABLE tx_cix_contactperson_zip (
    zip varchar(5) PRIMARY KEY,
    city TEXT,
    lng DOUBLE,
    lat DOUBLE
);

#
# Extend table structure of table 'sys_category'
#
CREATE TABLE sys_category (
    cix_zips TEXT DEFAULT '' NOT NULL,
    cix_keywords VARCHAR(255) DEFAULT '' NOT NULL
);
