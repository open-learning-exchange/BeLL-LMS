<?php
global $couchUrl;
$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';
include "../lib/couch.php";
include "../lib/couchClient.php";
include "../lib/couchDocument.php";


/// Actions View 
try{
  $client = new couchClient($couchUrl, 'actions');
  try{
      $apiDoc = $client->getDoc("_design/api");
      $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
    }
  $design_doc->_id = '_design/api';
  $design_doc->language = 'javascript';
  $design_doc->views = array ( 'memIdFacilityIdActionTime'=> array ('map' =>'function(doc) {
  emit([doc.memberId,doc.facilityId,doc.action], doc._id);
	}')
);
  $client->storeDoc($design_doc);
}catch(Exception $err){
 print("Facility api exist");   
}

//// Assignments View 
try{
  $client = new couchClient($couchUrl, 'assignments'); 
 try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
$design_doc->_id = '_design/api';
$design_doc->language = 'javascript';
$design_doc->views = array ( 
'facilityGroupID'=> array ('map' => 'function (doc) {
	if(doc.context["use"]!="video book task"){
    	emit([doc.context["facilityId"], doc.context["groupId"]],doc.resourceId);
	}
}'),
'facilityIdLesson_noteId'=> array ('map' => 'function (doc) {
	emit([doc.context["facilityId"], doc.context["lesson_noteId"]],true);
 }'),
'facilityIdMemberId'=> array ('map' => 'function (doc) {
  	emit([doc.context["facilityId"], doc.memberId], doc._id);
}'),
'facilityGroupIdVideoBook'=> array ('map' => 'function (doc) {
	if(doc.context["use"]=="video book task"){
    	emit([doc.context["facilityId"], doc.context["groupId"]],doc.resourceId);
	}
}'),
'facilityGroupIdAll'=> array ('map' => 'function (doc) {
    emit([doc.context["facilityId"], doc.context["groupId"]],doc.resourceId);
}')
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Assignment api exist <br />");
}

/// Exercises View 
try{
  $client = new couchClient($couchUrl, 'exercises');
  try{
      $apiDoc = $client->getDoc("_design/api");
      $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
    }
  $design_doc->_id = '_design/api';
  $design_doc->language = 'javascript';
  $design_doc->views = array ( 'facilityIdAssgnmentID'=> array ('map' =>'function(doc) {
  emit([doc.facilityId,doc.assignmentId], doc._id);
}')
);
  $client->storeDoc($design_doc);
}catch(Exception $err){
 print("Exercises api exist");   
}


/// Facilities View 
try{
  $client = new couchClient($couchUrl, 'facilities');
  try{
      $apiDoc = $client->getDoc("_design/api");
      $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
    }
  $view_fn="function(doc) {
              emit([doc.context['facilityId'], doc.context['groupId']],doc.resourceId);
                    }";
  $design_doc->_id = '_design/api';
  $design_doc->language = 'javascript';
  $design_doc->views = array ( 'facilityGroupID'=> array ('map' => $view_fn ) );
  $client->storeDoc($design_doc);
}catch(Exception $err){
 print("Facility api exist");   
}

//// Feedback View 
try{
  $client = new couchClient($couchUrl, 'feedback'); 
 try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
$design_doc->_id = '_design/api';
$design_doc->language = 'javascript';
$design_doc->views = array ( 
'facilityIdMemberID'=> array ('map' => "function (doc) {
  			emit(doc.facilityId + doc.memberId, doc._id);
		}"),
'facilityIdLesson_noteId'=> array ('map' => 'function (doc) {
	emit([doc.facilityId, doc.context["lesson_noteId"]],true);
 }'),
'facilityIdMemberId'=> array ('map' => 'function (doc) {
  	emit([doc.facilityId , doc.memberId], doc._id);
}')
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Feedback api exist <br />");
}



//// Groups View 
try{
  $client = new couchClient($couchUrl, 'groups'); 
 try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
$design_doc->_id = '_design/api';
$design_doc->language = 'javascript';
$design_doc->views = array ( 
'allGroupsInFacility'=> array ('map' => "function (doc) {
				 if(doc.level) {
				   emit(doc.facilityId, doc._id);
				 }
	}"),
'facilityLevel'=> array ('map' => "function (doc) {
 				if(doc.level) {
   					emit(doc.facilityId + doc.level, doc._id);
 				}
	}"),
'facilityMemberID'=> array ('map' => "function (doc) {
 			if(doc.level) {
   				emit(doc.facilityId + doc.members, doc._id);
 			}
	}"),
'facilityOwners'=> array ('map' => "function (doc) {
 				if(doc.level) {
   					emit(doc.facilityId, doc._id);
 				}
 	}"),
'facilityWithMemberID'=> array ('map' => "function (doc) {
			for(var cnt=0; cnt<doc.members.length; cnt++){
   				emit([doc.facilityId,doc.members[cnt]],doc._id);
			}
	}"),
'groupsByID'=> array ('map' => "function (doc) {
 				if(doc.level) {
   					emit(doc.facilityId, doc._id);
 			}
 }"),
'facilityIdLevel'=> array ('map' => "function (doc) {
 	for(var cnt=0;cnt<doc.level.length;cnt++){
   		emit([doc.facilityId,doc.level[cnt]], doc._id);
	}
 }")
 
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Feedback api exist <br />");
}



//// lesson_notes View 
try{
  $client = new couchClient($couchUrl, 'lesson_notes'); 
 try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
$design_doc->_id = '_design/api';
$design_doc->language = 'javascript';
$design_doc->views = array ( 
'facilityIdGroupId'=> array ('map' => "function (doc) {
      emit([doc.facilityId, doc.groupId],true);
 }"),
 'facilityIdMemberIdExecDate'=> array ('map' => "function (doc) {
      emit([doc.facilityId, doc.memberId],true);
 }")
 
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Lesson api exist <br />");
}


/// Members View 
try{
  $client = new couchClient($couchUrl, 'members');
  try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
  $view_fn="function(doc) {
                if(doc.login) {
                emit(doc.facilityId + doc.login, doc._id);
              }
            }";
  $design_doc->_id = '_design/api';
  $design_doc->language = 'javascript';
  $design_doc->views = array ( 'facilityLogin'=> array ('map' => $view_fn ),

'findMemberWithID'=> array ('map' => 'function(doc) {
var myBoolean = true;
for(var cnt=0;cnt<doc.roles.length;cnt++){
if(doc.roles[cnt]=="administrator"|| doc.roles[cnt]=="student"){
myBoolean = false;
return;
}
}
if(myBoolean){
emit(doc._id, doc.firstName);
}}'),

'listMemNotAdmin'=> array ('map' => 'function(doc) {
var myBoolean = true;
for(var cnt=0;cnt<doc.roles.length;cnt++){
if(doc.roles[cnt]=="administrator"|| doc.roles[cnt]=="student"){
myBoolean = false;
return;
}
}
if(myBoolean){
emit(doc.facilityId, doc._id);
}}'),

'facilityLevel'=> array ('map' => 'function(doc) {
	if(doc.levels) {
		if(doc.roles=="student" && doc.status=="active" ){
			emit(doc.facilityId + doc.levels, doc.lastName);
		}
	}
	}'),


'facilityLevelActive'=> array ('map' => 'function(doc) {
if(doc.levels) {
if(doc.roles=="student" && doc.status=="active" ){
emit(doc.facilityId + doc.levels, doc.lastName);
}
}}'),

'facilityLevelActive_allStudent_sorted'=> array ('map' => 'function(doc) {
if(doc.levels) {
if(doc.roles=="student" && doc.status=="active" ){
for( var cnt=0; cnt<doc.levels.length; cnt++){
emit([doc.facilityId, doc.levels[cnt], doc.lastName],true);
}
}
}}'),

'facilityLevelInactive_allStudent_sorted'=> array ('map' => 'function(doc) {
if(doc.levels) {
if(doc.roles=="student" && doc.status=="inactive" ){
for( var cnt=0; cnt<doc.levels.length; cnt++){
emit([doc.facilityId, doc.levels[cnt], doc.lastName],true);
}
}
}
}'),
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Members api exist \n");
}

//// Resources View 
try{
  $client = new couchClient($couchUrl, 'resources'); 
 try{
     $apiDoc = $client->getDoc("_design/api");
     $client->deleteDoc($apiDoc);
    }catch(Exception $delerr){
  }
 $view_fn="function(doc) {
emit(null,doc._id);
}";
$design_doc->_id = '_design/api';
$design_doc->language = 'javascript';
$design_doc->views = array ( 
'allResources'=> array ('map' => $view_fn ),
'allTeacherTraining'=> array ('map' => 'function(doc) {
	for(var cnt=0;cnt<doc.audience.length;cnt++){
		if(doc.audience[cnt]=="teacher training"){
				emit(null,doc._id);
				  }
					 }
}')
);
$client->storeDoc($design_doc);
}catch(Exception $err){
    print("Resources api exist <br />");
}

echo "Updated System Design Views";
?>
