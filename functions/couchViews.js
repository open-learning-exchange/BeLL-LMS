
MEMBERS
//@ members -> api -> facilityLogin
function(doc) {
  if(doc.login) {
    emit(doc.facilityId + doc.login, doc._id);
  }
}

// @ members -> api -> findMemberWithID
 function(doc) {
	var myBoolean = true;
	for(var cnt=0;cnt<doc.role.length;cnt++){
		if(doc.role[cnt]=="administrator"|| doc.role[cnt]=="student")
		{
			myBoolean = false;
			return;
		}
	}
	if(myBoolean){
		emit(doc._id, doc.firstName);
	}
}

// @ members ->api -> listMemNotAdmin
function(doc) {
	var myBoolean = true;
	for(var cnt=0;cnt<doc.role.length;cnt++){
		if(doc.role[cnt]=="administrator"|| doc.role[cnt]=="student")
		{
			myBoolean = false;
			return;
		}
	}
	if(myBoolean){
		emit(doc.facilityId, doc._id);
	}
}


GROUPS
//@ groups -> api -> allGroupsInFacility
function(doc) {
  if(doc.level) {
    emit(doc.facilityId, doc._id);
  }
}

//@ groups -> api -> facilityLevel
function(doc) {
  if(doc.level) {
    emit(doc.facilityId + doc.level, doc._id);
  }
}

//@ groups -> api -> facilityOwners
function(doc) {
  if(doc.level) {
    emit(doc.facilityId, doc._id);
  }
}

//@groups -> api ->groupsByID
function(doc) {
  if(doc.level) {
    emit(doc._id, doc._id);
  }
}

RESOURCES
//@resources -> api -> allResources
function(doc) {
   emit(null,doc._id);
}

Dtabases = 
assignments
facilities
groups
members
resources
whoami