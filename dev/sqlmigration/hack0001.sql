USE hackathon;

DROP TABLE IF EXISTS wishlist;
CREATE TABLE wishlist (
id int(32) UNSIGNED NOT NULL AUTO_INCREMENT,
product_name varchar(256) DEFAULT NULL,
url varchar(2048) DEFAULT NULL,
price decimal(6,2) DEFAULT 0.00,
new_price decimal (6,2) DEFAULT 0.00,
comment varchar(2048) DEFAULT NULL,
image varchar(2048) DEFAULT NULL,
wish_date datetime DEFAULT NULL,
PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT into wishlist (product_name, url, price, comment, wish_date) VALUES ('Playstation 3D Display', 'http://www.target.com/p/PlayStation-3D-Display-PlayStation-3/-/A-13693549', 399.99, 'Very cool display', NOW());
INSERT into wishlist (product_name, url, price, comment, wish_date) VALUES ('Westinghouse 24 inch LCD TV', 'http://www.target.com/p/Westinghouse-24-Class-1080p-60hz-LED-LCD-HDTV-Black-LD-2480/-/A-13585436', 199.00, 'Very cool LCD TV', NOW());
INSERT into wishlist (product_name, url, price, comment, wish_date) VALUES ('Kindle 6 inch ereader', 'http://www.amazon.com/Kindle-eReader-eBook-Reader-e-Reader-Special-Offers/dp/B0051QVESA/ref=amb_link_359598382_2?pf_rd_m=ATVPDKIKX0DER&pf_rd_s=center-1&pf_rd_r=1G5RPA3BS8ZR8CABG8QM&pf_rd_t=101&pf_rd_p=1342409702&pf_rd_i=507846', 79.00, 'Very cool e-reader', NOW());
INSERT into wishlist (product_name, url, price, comment, wish_date) VALUES ('Canon Camera', 'http://www.bestbuy.com/site/Canon+EOS+Rebel+T3i+18.0MP+DSLR+Camera%2C+Bag%2C+Memory+Card+%26+Extra+75-300mm+Lens/9999170900050004.p?id=pcmprd170600050004&skuId=9999170900050004', 929.26, 'Very cool camera', NOW());