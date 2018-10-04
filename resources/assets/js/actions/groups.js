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

export const = () => dispatch => {
  fetch( makeUriForRequest('/create-group'), {
    method: 'get'
  }).then(response => {
    
  });
};