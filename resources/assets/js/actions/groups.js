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
      'groupName='           + groupName + '&' +
      'groupMembersIdList=' + JSON.stringify(groupMembersIdList)

  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getGroups());
    });
  });
};