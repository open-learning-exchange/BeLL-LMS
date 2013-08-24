// members database
 var couchapp = require('couchapp')
  , path = require('path')
  ;

ddoc = 
  { _id:'_design/api'
  , rewrites : 
    [ {from:"/", to:'index.html'}
    , {from:"/api", to:'../../'}
    , {from:"/api/*", to:'../../*'}
    , {from:"/*", to:'*'}
    ]
  }
  ;

ddoc.views = {
	facilityLogin: {
           map: function(doc) {
      			if(doc.login) {
        			emit(doc.facilityId + doc.login, doc._id);
      			}
    		}
     },
    findMemberWithID: {
           map: function(doc) {
       	   	var myBoolean = true;
       	    for(var cnt=0;cnt<doc.roles.length;cnt++){
          		if(doc.roles[cnt]=='administrator'|| doc.roles[cnt]=='student'){
         			 myBoolean = false;
          			return;
          		}
       		}
       		if(myBoolean){
          		emit(doc._id, doc.firstName);
       		}
    	}
    },
   listMemNotAdmin: {
         map: function(doc) {
       			var myBoolean = true;
       			for(var cnt=0;cnt<doc.roles.length;cnt++){
          			if(doc.roles[cnt]=='administrator'|| doc.roles[cnt]=='student'){
					  	myBoolean = false;
					  	return;
					 }
       			}
       if(myBoolean){
          emit(doc.facilityId, doc._id);
       }
    }
  },
  facilityLevel: {
       map: function(doc) {
      		if(doc.levels) {
       			if(doc.roles=='student' && doc.status=='active' ){
       				emit(doc.facilityId + doc.levels, doc.lastName);
       			}
      		}
        }
  },
  facilityLevelActive: {
      map: function(doc) {
      		if(doc.levels) {
       			if(doc.roles=='student' && doc.status=='active' ){
		   			emit(doc.facilityId + doc.levels, doc.lastName);
       			}
     		}
    	}
     },
  facilityLevelActive_allStudent: {
     map: function(doc) {
      		if(doc.levels) {
       			if(doc.roles=='student' && doc.status=='active' ){
		   			 emit(doc.facilityId + doc.levels, doc.lastName);
       			}
      		}
    	}
   },
   facilityLevelInactive_allStudent: {
     map: function(doc) {
      	if(doc.levels) {
       		if(doc.roles=='student' && doc.status=='inactive' ){
       			emit(doc.facilityId + doc.levels, doc.lastName);
       		}
      	}
     }
   },
   facilityLevelActive_allStudent_sorted: {
     map: function(doc) {
      	if(doc.levels) {
       		if(doc.roles=='student' && doc.status=='active' ){
       			for( var cnt=0; cnt<doc.levels.length; cnt++){
           			emit([doc.facilityId, doc.levels[cnt], doc.lastName],true);
       			}
       		}
      	}
   	 }
   },
   facilityLevelInactive_allStudent_sorted: {
   		map: function(doc) {
      		if(doc.levels) {
       			if(doc.roles=='student' && doc.status=='inactive' ){
       				for( var cnt=0; cnt<doc.levels.length; cnt++){
           				emit([doc.facilityId, doc.levels[cnt], doc.lastName],true);
       				}
       			}
      		}
    	}
     }
	};

ddoc.validate_doc_update = function (newDoc, oldDoc, userCtx) {   
  if (newDoc._deleted === true && userCtx.roles.indexOf('_admin') === -1) {
    throw "Only admin can delete documents on this database.";
  } 
}

module.exports = ddoc;