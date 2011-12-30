USE hackathon;

DROP TABLE IF EXISTS wishlist;
CREATE TABLE wishlist (
id int(32) UNSIGNED NOT NULL,
product_name varchar(256) DEFAULT NULL,
url varchar(2048) DEFAULT NULL,
price decimal(6,2) DEFAULT 0.00,
wish_date datetime DEFAULT NULL,
PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;