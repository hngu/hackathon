var http = require('http'),
	sys = require('util'),
	express = require('express'),
	fs = require('fs'),
	wishlistMod = require('./modules/wishlists'),
	iframe;

app = express.createServer();
app.use(express.bodyParser());
app.use(express.errorHandler({
	dumpExceptions : true,
	showStack : true
}));

fs.readFile('./html/iframe.html', function(err, data) {
	if (err) {
		throw err;
	}
	iframe = data;
});

app.get('/', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	console.log('The one by one pixel popup was dropped down');
	res.write(iframe);
	res.end('');
});

app.get('/view', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	console.log('user ' + req.param('username') + ' is viewing his wishlist history');
	wishlistMod.getWLFromDB(req.param('username'), function(data) {
		wishlistMod.displayWL(res, data, '0');
		res.end('');
	});
});

app.get('/fengsecret', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	console.log('Admin is viewing all wishlists');
	wishlistMod.getWLFromDB(null, function(data) {
		wishlistMod.displayWL(res, data, '1');
		res.end('');
	});
});

app.get('/view/:id/:type', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	wishlistMod.singleItemActionFromDB(req.params.id, 'GET', null, function(data) {
		wishlistMod.displayItem(res, data, req.params.type);
		res.end('');
	});
});

app.get('/view/:id/:type/edit', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	wishlistMod.singleItemActionFromDB(req.params.id, 'GET', null, function(data) {
		console.log(req.params);
		wishlistMod.displayEditItem(res, data, req.params.type);
		res.end('');
	});
});

app.get('/view/:id/:type/delete', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	wishlistMod.singleItemActionFromDB(req.params.id, 'GET', null, function(data) {
		wishlistMod.displayDelItem(res, data);
		res.end('');
	})
});

app.post('/edit/:id/:type', function(req, res) {
	console.log(req);
	req.body.item.time = new Date().getTime();
	wishlistMod.singleItemActionFromDB(req.params.id, 'SAVE', req.body.item, function(data) {
		if('1' === req.params.type) {
			res.writeHead(200, {
				'Content-Type' : 'text/html'
			});
			res.end('Update on wishlist (name: ' + req.body.item.name + ') has been saved! <br><a href="/fengsecret">Return to wishlist</a>');
		} else {
			res.writeHead(200, {
				'Content-Type' : 'text/html'
			});
			res.end('Update on wishlist (name: ' + req.body.item.name + ') has been saved! <br><a href="/view?username=' + req.body.item.username + '">Return to wishlist</a>');
		}
	});
});

app.post('/delete/:id/:type', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	wishlistMod.singleItemActionFromDB(req.params.id, 'DELETE', null, function(data) {
		if('1' === req.params.type) {
			res.end('Product id: [' + req.params.id + '] has been deleted! <br><a href="/fengsecret">Return to wishlist</a>');
		} else {
			res.end('Product id: [' + req.params.id + '] has been deleted! <br><a href="/view?username=' + req.params.type + '">Return to wishlist</a>');
		}
	});
});

app.post('/search', function(req, res) {
	res.writeHead(200, {
		'Content-Type' : 'text/html'
	});
	console.log('Search wishlists with keyword: ' + req.body.keyword + ' in Mongodb');
	wishlistMod.singleItemActionFromDB(req.params.id, 'SEARCH', req.body.keyword, function(data) {
		console.log(data);
		res.write('<br><a href="/fengsecret">Return to all wishlists</a></br>\n');
		wishlistMod.displaySearchResults(res, data);
		res.end('');
	});	
});

app.post('/add', function(req, res) {
	console.log('new wishlist received');
	res.writeHead(200, {
		'Content-Type' : 'text/json'
	});
	req.body.time = new Date().getTime();
	wishlistMod.addWLToDB(req.body, function(data) {
		if(data == null) {
			console.log('New wishlist ' + req.body.name + ' has been added');
			res.end('{"code":200,"msg":"New wishlist ' + req.body.name + ' has been added"}');
		} else {
			if(data.code == 400) {
				console.log(data.msg);
				res.end('{"code":400,"msg":"This item already existed in your wishlist, please add a new one"}');
			} else {
				console.log('db failure');
				res.end('{"code":404,"msg":"System failure, please try again later"}');
			}
		}
	});
});

app.listen(3000);
console.log('Server is running at port 3000');