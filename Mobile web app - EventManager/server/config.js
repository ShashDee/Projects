/*
exports.mongohq   = { 
  username: 'your_database_username',      
  password: 'your_database_password',
  name:     'event_manager',
  host:     'your_host_url',
  port:     your_port
}
*/

exports.mongohq   = { 
  username: 'root-user',
  password: '123',
  name:     'event_manager',
  host:     'eventmanager-shard-00-00-sfs1m.mongodb.net',
  port:     27017
}

//exports.server = 'your_server_url'
exports.server = 'eventmanager-shard-00-00-sfs1m.mongodb.net:27017'
exports.max_stream_size = 100

