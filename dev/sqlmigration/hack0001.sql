USE hackathon;

DROP TABLE IF EXISTS wishlist;
CREATE TABLE wishlist (
upc bigint(20) unsigned NOT NULL,
price decimal(10,2) DEFAULT 0.00,
product_name varchar(32) DEFAULT NULL,
url varchar(512) DEFAULT NULL,
date_time datetime DEFAULT NULL,
PRIMARY KEY (upc)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
