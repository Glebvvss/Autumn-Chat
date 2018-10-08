import { scrfToken, makeUriForRequest } from '../functions.js';

export const getGroups = () => dispatch => {
  fetch( makeUriForRequest('/get-groups'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({ type: 'FETCH_GROUPS', payload: data.groups });
    });
  });
};

export const createGroup = (groupName, groupMembersIdList) => dispatch => {
  fetch( makeUriForRequest('/create-group'), {
    method: 'post',
    headers: {
      'X-CSRF-TOKEN': scrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body:
      'groupName='          + groupName + '&' +
      'groupMembersIdList=' + JSON.stringify(groupMembersIdList)

  }).then(response => {
    console.log(response);
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getGroups());
    });
  });
};

export const getFriendsWhoNotInGroup = groupId => dispatch => {
  fetch( makeUriForRequest('/get-all-friends-who-not-in-group/' + groupId), {
    method: 'get',
  }).then(response => {
    response.json().then(data => {
      dispatch({ 
        type: 'FETCH_FRIENDS_WHO_NOT_IN_SELECTED_GROUP', 
        payload: data.friendsWhoNotInGroup
      });
    });
  });
};

export const getMembersOfGroup = groupId => dispatch => {
  fetch( makeUriForRequest('/get-members-of-group/' + groupId), {
    method: 'get',
  }).then(response => {
    response.json().then(data => {
      dispatch({
        type: 'FETCH_MEMBERS_OF_SELECTED_GROUP', 
        payload: data.membersOfGroup 
      });
    });
  });
};