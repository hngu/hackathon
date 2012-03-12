var mongo = require('mongodb');
db = null;

function getWLFromDB(username, cb) {
	if (!db) {
		__init();
	}
	db.open(function() {
		db.collection('wishlist', function(err, coll) {
			if(null == username) {
				console.log('db is open to get all users" wishlists history');
				coll.find({}, function(err, docs) {
					docs.toArray(function(err, arr) {
						if (!err) {
							cb(arr);
							db.close();
						}
					});
				});
			} else {
				console.log('db is open to get one user"s wishlist history');
				coll.find({
					username : username
				}, function(err, docs) {
					docs.toArray(function(err, arr) {
						if (!err) {
							cb(arr);
							db.close();
						}
					});
				});
			}
		});
	});
}

function singleItemActionFromDB(id, action, item, cb) {
	if (!db) {
		__init();
	}
	db.open(function() {
		console.log('db is open');
		db.collection('wishlist', function(err, coll) {
			if('GET' == action) {
				console.log('get wishlist item [' + id + '] is ready');
				coll.findOne({
					_id : mongo.ObjectID(id)
				}, function(err, docs) {
					if(!err) {
						console.log('wishlist item [' + id + '] is found');
						cb(docs);
						db.close();
					}					
				});
			} else if('SAVE' == action) {
				console.log('save wishlist item [' + id + '] is ready');
				coll.update({
					_id : mongo.ObjectID(id)
				}, {
					$set : item
				}, function(err) {
					cb(err);
				});
			} else if('DELETE' == action) {
				console.log('delete wishlist item [' + id + '] is ready');
				coll.remove ({
					_id : mongo.ObjectID(id)
				}, function(err) {
					cb(err);
				});
			} else if('SEARCH' == action) {
				console.log('db is open for search');
				keyword = '(^|\\W)' + item + '($|\\W)';
				coll.find({
					name : {
						$regex : keyword,
						$options : 'i'
					}
				}, function(err, docs) {
					docs.toArray(function(err, arr) {
						if (!err) {
							cb(arr);							
						}
					});
				});
			} else {
				cb({msg: 'invalid action'});
			}
		});
	});	
}

function addWLToDB(wishlist, cb) {
	if (!db) {
		__init();
	}
	db.open(function() {
		db.collection('wishlist', function(err, coll) {
			console.log('db is open to add new wishlist ' + wishlist.name);
			coll.find({
				name : wishlist.name,
				username : wishlist.username
			}, function(err, docs) {
				if(!err) {
					docs.toArray(function(err, arr) {
						if(!err) {
							console.log(arr.length + ' existing wishlists');
							if(arr.length > 0) {
								cb({code: 400, msg: "duplicate wishlist"});
								db.close();
								return;
							} else {
								coll.insert(wishlist, function(err) {
									cb(err);
									db.close();
									return;
								});
							}
						}
					});
				}
			});
		});
	});
}

function displayWL(res, wishlist, type) {
	var i;
	if('1' === type) {
		res.write('<form method="POST" action="/search/">\n');
		res.write('<input type="text" name="keyword" value="">\n');
		res.write('<input type="Submit" name="search" value="Search"></br>\n');
		res.write('</form>\n');
		res.write('<table border="1">');
		res.write('<tr><th>ID</th><th>Toolbar ID</th><th>Username</th><th>Time</th><th>Item</th><th>Price</th><th>Action</th></tr>');
		for (i = 0; i < wishlist.length; i++) {
			var wishlistdate = new Date(wishlist[i].time);
			res.write('<tr><td>' + i + '</td><td>' + wishlist[i].toolid + '</td>'
					+ '<td>' + wishlist[i].username + '</td>'
					+ '<td>' + wishlistdate.toLocaleString() + '</td>'
					+ '<td>' + wishlist[i].name + '</td>'
					+ '<td>' + wishlist[i].price + '</td>'
					+ '<td><a href="/view/' + wishlist[i]._id + '/' + type + '">View</a>'
					+ '| <a href="/view/' + wishlist[i]._id +  '/' + type + '/edit">Edit</a>'
					+ '| <a href="/view/' + wishlist[i]._id +  '/' + type + '/delete">Delete</a>'
					+ '</td></tr>');
		}
		res.write('</table>');
	} else {
		if(wishlist.length < 1) {
			res.write('Huh, you have nothing in your wishlist. Make a wish, hurry up!')
		} else {
			res.write('<table border="1">');
			res.write('<tr><th>ID</th><th>Item</th><th>Price</th><th>Availability</th><th>Action</th></tr>');
			for (i = 0; i < wishlist.length; i++) {
				res.write('<tr><td>' + i + '</td><td>' + wishlist[i].name + '</td>'
						+ '<td>' + wishlist[i].price + '</td>'
						+ '<td>' + wishlist[i].available + '</td>'
						+ '<td><a href="/view/' + wishlist[i]._id + '/' + type + '">View</a>'
						+ '| <a href="/view/' + wishlist[i]._id + '/' + type + '/edit">Edit</a>'
						+ '| <a href="/view/' + wishlist[i]._id + '/' + type + '/delete">Delete</a>'
						+ '</td></tr>');
			}
			res.write('</table>');
		}
	}	
}

function displayItem(res, item, type) {
	if('1' === type) {
		res.write('<table border="1"><tr><td><b>Toolbar ID</b></td><td>' + item.toolid + '</td>');
		res.write('<td rowspan="7"><img border="0" src="' + item.image + '"/></td></tr>');
		res.write('<tr><td><b>Userid</b></td><td>' + item.userid + '</td></tr>');
		res.write('<tr><td><b>Username</b></td><td>' + item.username + '</td></tr>');
		res.write('<tr><td><b>Product</b></td><td><a href = "' + item.url + '">' + item.name + '</a></td></tr>');
		res.write('<tr><td><b>Price</b></td><td>' + item.price + '</td></tr>');
		res.write('<tr><td><b>Availability</b></td><td>' + item.available + '</td></tr>');
		var itemDate = new Date(item.time);
		res.write('<tr><td><b>Date Modified</b></td><td>' + timeDifference(itemDate)
				+ '<br>' + itemDate.toLocaleString() + '</td></tr>');
		res.write('</table>');
		res.write('<a href="/fengsecret">Return to all wishlists</a></br>\n');
	} else {
		res.write('<table border="1"><tr><td><b>Product</b></td><td><a href = "' + item.url + '">' + item.name + '</a></td>');
		res.write('<td rowspan="4"><img border="0" src="' + item.image + '"/></td></tr>');
		res.write('<tr><td><b>Price</b></td><td>' + item.price + '</td></tr>');
		res.write('<tr><td><b>Availability</b></td><td>' + item.available + '</td></tr>');
		var itemDate = new Date(item.time);
		res.write('<tr><td><b>Date Modified</b></td><td>' + timeDifference(itemDate)
				+ '<br>' + itemDate.toLocaleString() + '</td></tr>');
		res.write('</table>');
		res.write('<a href="/view?username=' + item.username + '">Return to all wishlists</a></br>\n');
	}
}

function displayEditItem(res, item, type) {
	if (item._id) {
		if('1' === type) {
			res.write('<form method="POST" action="/edit/' + item._id + '/' + type + '">\n');
			res.write('Toolbarid: <input type="text" name="item[toolid]" value="' + item.toolid + '"></br>\n');
			res.write('Userid: <input type="text" name="item[userid]" value="' + item.userid + '"></br>\n');
			res.write('Username: <input type="text" name="item[username]" value="' + item.username + '"></br>\n');
			res.write('URL: <input type="text" name="item[url]" value="' + item.url + '"></br>\n');
			res.write('Price: <input type="text" name="item[price]" value="' + item.price + '"></br>\n');
			res.write('Product Name: <input type="text" name="item[name]" value="' + item.name + '"></br>\n');
			res.write('Availability: <input type="text" name="item[available]" value="' + item.available + '"></br>\n');
			res.write('Image URL: <input type="text" name="item[image]" value="' + item.image + '"></br>\n');
			res.write('<input type="Submit" name="save" value="Save"></br>\n');
			res.write('</form>');
			res.write('<a href="/fengsecret">Return to all wishlists</a></br>\n');
		} else {
			res.write('<form method="POST" action="/edit/' + item._id + '/' + type + '">\n');
			res.write('Username: <input type="text" name="item[username]" value="' + item.username + '"></br>\n');
			res.write('Product Name: <input type="text" name="item[name]" value="' + item.name + '"></br>\n');
			res.write('Price: <input type="text" name="item[price]" value="' + item.price + '"></br>\n');			
			res.write('Availability: <input type="text" name="item[available]" value="' + item.available + '"></br>\n');
			res.write('<input type="Submit" name="save" value="Save"></br>\n');
			res.write('</form>');
			res.write('<a href="/view?username=' + item.username + '">Return to all wishlists</a></br>\n');
		}
	} else {
		res.write('item not found with id = ' + item._id + '</br>\n');
	}
}

function displayDelItem(res, item, type) {
	if (item._id) {
		if('1' === type) {
			res.write('<form method="POST" action="/delete/' + item._id + '/' + type + '/">\n');
			res.write('Are you sure you want to delete this item from wishlist?\n');
			res.write('<input type="Submit" name="delete" value="Delete"></br>\n');
			res.write('</form>');
			res.write('<a href="/fengsecret">Return to all wishlists</a></br>\n');
		} else {
			res.write('<form method="POST" action="/delete/' + item._id + '/' + item.username + '/">\n');
			res.write('Are you sure you want to delete this item from wishlist?\n');
			res.write('<input type="Submit" name="delete" value="Delete"></br>\n');
			res.write('</form>');
			res.write('<a href="/view?username=' + item.username + '">Return to all wishlists</a></br>\n');
		}		
	} else {
		res.write('item not found with id = ' + item._id + '</br>\n');
	}
}

function displaySearchResults(res, wishlist) {
	res.write('<br>Total ' + wishlist.length + ' ' + (wishlist.length > 1 ? 'results' : 'result') + ' returned<br>\n');
	for (i = 0; i < wishlist.length; i++) {
		console.log('search result #' + i + ': ' + wishlist[i].name + ' displayed');
		res.write('<table border="1"><tr><td>Username</td><td><b>' + wishlist[i].username + '</b></td></tr>');
		res.write('<tr><td>Toolbarid</td><td>' + wishlist[i].toolid + '</td></tr>');
		res.write('<tr><td>Userid</td><td>' + wishlist[i].userid + '</td></tr>');
		res.write('<tr><td>Prod Name</td><td>' + wishlist[i].name + '</td></tr>');
		res.write('<tr><td>URL</td><td>' + wishlist[i].url + '</td></tr>');
		res.write('<tr><td>Price</td><td>' + wishlist[i].price + '</td></tr>');
		res.write('<tr><td>Availability</td><td>' + wishlist[i].available + '</td></tr>');
		res.write('<tr><td>Image URL</td><td>' + wishlist[i].image + '</td></tr>');
		var wishlistdate = new Date(wishlist[i].time);
		res.write('<tr><td>Date added</td><td>' + timeDifference(wishlistdate) + '<br>' + wishlistdate.toLocaleString() + '</td></tr>');
		res.write('</table>');
		res.write('<br>\n<br>\n');
	}
}

//function to calculate time difference
function timeDifference(time) {
	var diff = (new Date().getTime() - time) / 1000, day_diff = Math
			.floor(diff / 86400);
	if (isNaN(day_diff) || day_diff < 0 || day_diff >= 31) {
		return;
	}
	return day_diff == 0
			&& (diff < 60 && "just now" || diff < 120 && "1 minute ago"
					|| diff < 3600 && Math.floor(diff / 60) + " minutes ago"
					|| diff < 7200 && "1 hour ago" || diff < 86400
					&& Math.floor(diff / 3600) + " hours ago") || day_diff == 1
			&& "Yesterday" || day_diff < 7 && day_diff + " days ago"
			|| day_diff < 31 && Math.ceil(day_diff / 7) + " weeks ago";
}

function __init() {
	db = new mongo.Db('wishlist', new mongo.Server('127.0.0.1', 27017, {}), {});
}

module.exports = {
	getWLFromDB : getWLFromDB,
	displayWL : displayWL,
	singleItemActionFromDB : singleItemActionFromDB,
	addWLToDB : addWLToDB,
	displayItem : displayItem,
	displayEditItem : displayEditItem,
	displayDelItem : displayDelItem,
	displaySearchResults : displaySearchResults	
};
