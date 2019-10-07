
var util     = exports.util     = require('util')
var express  = exports.express  = require('express')
var uuid     = exports.uuid     = require('node-uuid')
var url      = exports.url      = require('url')
var request  = exports.request  = require('request')
var fs       = exports.fs = require('fs')
var bodyParser = exports.bodyParser = require('body-parser');
var express  = exports.express = require('express')
var MongoClient = exports.MongoClient = require("mongodb").MongoClient
var config = exports.config = require('./config.js')

// JSON functions
exports.readjson = function(req,win,fail) {
  var bodyarr = [];
  req.on('data',function(chunk){
    bodyarr.push(chunk);
  })
  req.on('end',function(){
    var bodystr = bodyarr.join('');
    console.error('READJSON:'+req.url+':'+bodystr);
    try {
      var body = JSON.parse(bodystr);
      win && win(body);
    }
    catch(e) {
      fail && fail(e)
    }
  })
}

exports.sendjson = function(res,obj){
  res.writeHead(200,{
    'Content-Type': 'text/json',
    'Cache-Control': 'private, max-age=0'
  });
  var objstr = JSON.stringify(obj);
  console.error('SENDJSON:'+objstr);
  res.end( objstr );
}


// mongo functions

var mongodb = require('mongodb')

var mongo = {
  mongo: mongodb,
  db: null,
}

var options = {
    auto_reconnect: true, useNewUrlParser: true, keepAlive: 1, connectTimeoutMS: 300000, socketTimeoutMS: 0
}

mongo.init = function( opts, win, fail )
{
    console.error('mongo: '+opts.host+':'+opts.port+'/'+opts.name)

    // Connection String
    //MongoClient.connect("mongodb://<your_username>:<your_Password>@<your_server>.mongohq.com:<your_port>/<your_dbase>", options,
    MongoClient.connect("mongodb+srv://root-user:123@eventmanager-sfs1m.mongodb.net/event_manager?retryWrites=true&w=majority", options,
    function(err, client)
    {
        if (err) // if connection failed
        {
            console.error('Error opening or authenticating Mongo Atlas database') // print error message to server
        }
        else // if connection was successful
        {
            mongo.db = client.db('event_manager') // get database
            win && win(mongo.db)
        }
    })
}

mongo.res = function( win, fail ){
  return function(err,res) {
    if( err ) {
      util.log('mongo:err:'+JSON.stringify(err));
      fail && 'function' == typeof(fail) && fail(err);
    }
    else {
      win && 'function' == typeof(win) && win(res);
    }
  }
}

mongo.open = function(win,fail){
  mongo.db.open(mongo.res(function(){
    util.log('mongo:ok');
    win && win();
  },fail))
}

mongo.coll = function(name,win,fail){
  mongo.db.collection(name,mongo.res(win,fail));
}

exports.mongo = mongo

