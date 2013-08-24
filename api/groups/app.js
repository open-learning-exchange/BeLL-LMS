/// groups database 
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
  allGroupsInFacility: {
          map:function(doc) {
				 if(doc.level) {
				   emit(doc.facilityId, doc._id);
				 }
			}
       },
   facilityLevel: {
          map:function(doc) {
 				if(doc.level) {
   					emit(doc.facilityId + doc.level, doc._id);
 				}
		  }
       },
   groupsByID: {
          map:function(doc) {
 				if(doc.level) {
   					emit(doc.facilityId, doc._id);
 			}
		  }
       },
  facilityOwners: {
          map:function(doc) {
 				if(doc.level) {
   					emit(doc.facilityId, doc._id);
 				}
 			}
       },
   facilityMemberID: {
          map:function(doc) {
 			if(doc.level) {
   				emit(doc.facilityId + doc.members, doc._id);
 			}
		}
       },
   facilityWithMemberID: {
          map:function(doc) {
			for(var cnt=0; cnt<doc.members.length; cnt++){
   				emit([doc.facilityId,doc.members[cnt]],doc._id);
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