// getting necessary packages
var common  = require('./common.js')
var config  = common.config
var mongo   = common.mongo
var util    = common.util
var uuid    = common.uuid
var url     = common.url
var request = common.request
var bodyParser = common.bodyParser;
var express = common.express;
var fs = common.fs

// API functions

// fetch function to fetch all records from the cloud database
function fetch(req, res)
{
    // setting cross origin settings to allow requests between application and server
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

    // printing to server
    console.log("\nGot here.. " + req.params.module);

    var collection;
    var query = {};

    // setting the collection to fetch data
    if(req.params.module == "evt_types")
        collection = "event_types";
    else if(req.params.module == "venues")
        collection = "venues";
    else if(req.params.module == "suppliers")
        collection = "suppliers";
    else if(req.params.module == "customers")
        collection = "customers";
    else if(req.params.module == "events")
        collection = "events";
    else if(req.params.module == "home_events")
    {
        collection = "events";
        query = {event_complete: "0"} // getting only on going events here
    }

    var merr = mongoerr400(res);

    // querying the mongoDB database

    if(req.params.module == "events")// when fetching all events joins are used to get venue, customer and event type names
    {
        mongo.coll(collection,
            function(coll){
                coll.aggregate([
                   {$lookup: {from: "event_types",localField: "event_type",foreignField: "_id",as: "event_type"}},
                   {$unwind : "$event_type"},
                   {$lookup: {from: "venues", localField: "venue_id",foreignField: "_id",as: "venue"}},
                   {$unwind : "$venue"},
                   {$lookup: {from: "customers", localField: "customer",foreignField: "_id",as: "customer"}},
                   {$unwind : "$customer"},
                   {$project: {_id: 1, event_code: 1, event_name: 1, event_date: 1, start_time: 1, end_time: 1, hall_name: 1, event_complete: 1, event_type: "$event_type.type_name", venue_name: "$venue.venue_name", customer_title: "$customer.customer_title", customer_name: "$customer.customer_name"}}],
                    merr(function(cursor)
                    {
                        var list = [];

                        cursor.each(merr(function(log)
                        {
                            if( log )
                            {
                                list.push(log)
                            }
                            else
                            {
                                common.sendjson(res,{ok:true,list:list})
                            }
                        }))
                    })
                )
            }
        )
    }
    else // for fetching records of other modules
    {
        mongo.coll(collection,
            function(coll){
                coll.find(
                    query,
                    merr(function(cursor)
                    {
                        var list = [];

                        cursor.each(merr(function(log)
                        {
                            if( log )
                            {
                                list.push(log)
                            }
                            else
                            {
                                common.sendjson(res,{ok:true,list:list})
                            }
                        }))
                    })
                )
            }
        )
    }
}

// function to fetch one specific record from the cloud database
function search(req, res)
{
    // setting cross origin settings to allow requests between application and server
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

    // printing to server
    console.log("\nSearching for.. " + req.params.module);

    var collection;
    var query;
    var id;

    // setting the collection to fetch data
    if(req.params.module == "event_type")
        collection = "event_types";
    else if(req.params.module == "venue")
        collection = "venues";
    else if(req.params.module == "supplier")
        collection = "suppliers";
    else if(req.params.module == "customer")
        collection = "customers";
    else if(req.params.module == "event")
        collection = "events";
    else if(req.params.module == "checklist")
        collection = "checklists";
    else if(req.params.module == "agenda")
            collection = "agendas";

    // mongoDB saves ID as an ObjectID. 
    // Thus, the id which is passed as string is converted to an ObjectID
    var mongodb = require('mongodb');
    var id = new mongodb.ObjectID(req.params.id);

    if(req.params.module == "checklist" || req.params.module == "agenda")
        query = {event_id: id};
    else
        query = {_id: id};

    // printing to server
    console.log(JSON.stringify(query)+ "\n");

    var merr = mongoerr400(res);

    // querying the mongoDB database
    mongo.coll(collection,
        function(coll){
            coll.find(
                query,
                merr(function(cursor)
                {
                    var list = [];

                    cursor.each(merr(function(log)
                    {
                        if( log )
                        {
                            list.push(log)
                        }
                        else
                        {
                            common.sendjson(res,{ok:true,list:list})
                        }
                    }))
                })
            )
        }
    )
}

// function to save a record to the cloud database
function save(req, res)
{
    // setting cross origin settings to allow requests between application and server
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'POST GET OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    res.header('Access-Control-Allow-Credentials', 'true');

    // printing to server
    console.log("\nAdding an... " + req.params.module);

    var collection;

    // empty list to hold ids of all inserted records
    var id_list = [];

    if(req.params.module == "event_type")
    {
        collection = "event_types";

        // collecting the ids of the event types
        id_list.push(req.body.type_code);
    }
    else if(req.params.module == "venue")
    {
        collection = "venues";

        // collecting the ids of the venues
        id_list.push(req.body.venue_name);
    }
    else if(req.params.module == "supplier")
    {
        collection = "suppliers";

        // collecting the ids of the suppliers
        id_list.push(req.body.supplier_name);
    }
    else if(req.params.module == "customer")
    {
        collection = "customers";

        // collecting the ids of the customers
        id_list.push(req.body.customer_name);
    }
    else if(req.params.module == "event")
    {
        collection = "events";

        // converting IDs passed as string to ObjectIDs
        var mongodb = require('mongodb');
        req.body.event_type = new mongodb.ObjectID(req.body.event_type);
        req.body.venue_id = new mongodb.ObjectID(req.body.venue_id);
        req.body.customer = new mongodb.ObjectID(req.body.customer);

        // collecting the ids of the events
        id_list.push(req.body.event_code);
    }
    else if(req.params.module == "checklist")
    {
        collection = "checklists";

        // converting ID passed as string to ObjectID
        var mongodb = require('mongodb');
        req.body.event_id = new mongodb.ObjectID(req.body.event_id);

        // collecting the ids of the checklists
        id_list.push(req.body.event_id);
    }
    else if(req.params.module == "agenda")
    {
        collection = "agendas";

        // converting ID passed as string to ObjectID
        var mongodb = require('mongodb');
        req.body.event_id = new mongodb.ObjectID(req.body.event_id);

        // collecting the ids of the agendas
        id_list.push(req.body.event_id);
    }

    // printing to the server
    console.log("\n" + JSON.stringify(req.body));

    // inserting the record to the cloud database
    mongo.coll(collection,
        function(coll){
            coll.insertOne(
                req.body
            )
        }
    )

    // printing SENDJSON in server
    common.sendjson(res,{ok: true, id: id_list})
}

// function to update a record in the cloud database
function edit(req, res)
{
    // setting cross origin settings to allow requests between application and server
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'POST GET OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    res.header('Access-Control-Allow-Credentials', 'true');

    // printing to server
    console.log("\nUpdating an.. " + req.params.module);

    var collection;
    var query;
    var new_values;
    var mongodb = require('mongodb');

    if(req.params.module == "event_type")
    {
        collection = "event_types";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);

        // setting values to be updated
        new_values = { $set: {type_code: req.body.type_code, type_name: req.body.type_name } };
        query = {_id: id};
    }
    else if(req.params.module == "venue")
    {
        collection = "venues";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);
        new_values = { $set: {venue_name: req.body.venue_name, contact_no: req.body.contact_no, address: req.body.address, email: req.body.email, halls: req.body.halls } };
        query = {_id: id};
    }
    else if(req.params.module == "supplier")
    {
        collection = "suppliers";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);

        // setting values to be updated
        new_values = { $set: {supplier_name: req.body.supplier_name, supplier_contact_name: req.body.supplier_contact_name, supplier_contact_designation: req.body.supplier_contact_designation, supplier_contact_no: req.body.supplier_contact_no, supplier_address: req.body.supplier_address, supplier_email: req.body.supplier_email } };
        query = {_id: id};
    }
    else if(req.params.module == "customer")
    {
        collection = "customers";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);

        // setting values to be updated
        new_values = { $set: {customer_title: req.body.customer_title, customer_name: req.body.customer_name, customer_contact_no: req.body.customer_contact_no, customer_address: req.body.customer_address, customer_email: req.body.customer_email, registered_date: req.body.registered_date } };
        query = {_id: id};
    }
    else if(req.params.module == "event")
    {
        collection = "events";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);
        req.body.event_type = new mongodb.ObjectID(req.body.event_type);
        req.body.venue_id = new mongodb.ObjectID(req.body.venue_id);
        req.body.customer = new mongodb.ObjectID(req.body.customer);

        // setting values to be updated
        new_values = { $set: {event_code: req.body.event_code, event_name: req.body.event_name, event_date: req.body.event_date, start_time: req.body.start_time, end_time: req.body.end_time, event_type: req.body.event_type, venue_hall: req.body.venue_hall, venue_id: req.body.venue_id, hall_name: req.body.hall_name, customer: req.body.customer, event_budget: req.body.event_budget, remarks: req.body.remarks, event_complete: req.body.event_complete } };
        query = {_id: id};
    }
    else if(req.params.module == "checklist")
    {
        collection = "checklists";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);
        req.body.event_id = new mongodb.ObjectID(req.body.event_id);

        // setting values to be updated
        new_values = { $set: {event_id: req.body.event_id, items: req.body.items} };
        query = {_id: id};
    }
    else if(req.params.module == "agenda")
    {
        collection = "agendas";

        // converting ID passed as string to ObjectID
        var id = new mongodb.ObjectID(req.body.id);
        req.body.event_id = new mongodb.ObjectID(req.body.event_id);

        // setting values to be updated
        new_values = { $set: {event_id: req.body.event_id, agenda: req.body.agenda} };
        query = {_id: id};
    }

    // empty list to hold ids of all inserted records
    var id_list = [];

    // collecting the ids of the records
    id_list.push(req.body.id);

    // inserting the record to the cloud database
    mongo.coll(collection,
        function(coll){
            coll.updateOne(
                query, new_values, function(err, res)
                {
                    if (err) throw err;
                }
            )
        }
    )

    // printing SENDJSON in server
    common.sendjson(res,{ok: true, id: id_list})
}

// function to delete a record in the cloud database
function deleteRecord(req, res)
{
    // setting cross origin settings to allow requests between application and server
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'POST GET OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    res.header('Access-Control-Allow-Credentials', 'true');

    // printing to server
    console.log("\nDeleting an.. " + req.params.module);

    var collection;
    var query;
    var mongodb = require('mongodb');

    // setting collection to fetch data
    if(req.params.module == "event_type")
        collection = "event_types";
    else if(req.params.module == "venue")
        collection = "venues";
    else if(req.params.module == "supplier")
        collection = "suppliers";
    else if(req.params.module == "customer")
        collection = "customers";
    else if(req.params.module == "event")
        collection = "events";

    // converting ID passed as string to ObjectID
    var id = new mongodb.ObjectID(req.body.id);
    query = {_id: id};

    // empty list to hold ids of all deleted records
    var id_list = [];

    // collecting the ids of the records
    id_list.push(req.body.id);

    // deleting the record to the cloud database
    mongo.coll(collection,
      function(coll){
          coll.deleteOne(
              query
          )
      }
    )

    // when deleting an event its respective checklist and agenda is also deleted
    if(req.params.module == "event")
    {
        // deleting checklist of event
        mongo.coll("checklists",
          function(coll){
              coll.deleteOne(
                  {event_id: id}
              )
          }
        )

        // deleting agenda of event
        mongo.coll("agendas",
          function(coll){
              coll.deleteOne(
                  {event_id: id}
              )
          }
        )
    }

    // printing SENDJSON in server
    common.sendjson(res,{ok: true, id: id_list})
}

// function for error handling in mongo queries
function mongoerr400(res)
{
    return function(win)
    {
        return mongo.res(win,
            function(dataerr)
            {
                err400(res)(dataerr);
            }
        )
    }
}

function err400(res,why)
{
    return function(details)
    {
        console.error('ERROR 400 '+why+' '+details);
        res.writeHead(400,''+why);
        res.end(''+details);
    }
}

// setting database up and declaring API functions
var db = null;
var app = null;

mongo.init({
    name:     config.mongohq.name,
    host:     config.mongohq.host,
    port:     config.mongohq.port,
    username: config.mongohq.username,
    password: config.mongohq.password },
    function(res)
    {
        // printing tp sever
        console.log("In server");

        db = res;
        var prefix = '/Events/';
        app = express();

        // Configuration
        app.use(bodyParser.json());

        // API functions
        app.get(prefix + ':module/fetch', fetch);
        app.get(prefix + 'search/:module/:id', search);
        app.post(prefix + ':module/save', save);
        app.post(prefix + ':module/edit', edit);
        app.post(prefix + ':module/delete', deleteRecord);

        // Setting port
        app.listen(3009);

        // Printing to server
        console.error('Server listening on port 3009');
    },
    function(err)
    {
        console.error(err);
    }
)


