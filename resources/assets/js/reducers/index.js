import { combineReducers } from 'redux';
import { registration } from './auth/registration.js';
import { checkLogin } from './auth/checkLogin.js';
import { userInfo } from './auth/userInfo.js';
import { login } from './auth/login.js';
import { friendshipRequests } from './contacts/friends/friendshipRequests.js';
import { searchFriends } from './contacts/friends/searchFriends.js';
import { friends } from './contacts/friends/friends.js';
import { notification } from './notification';
import { sidebarDropdownElements } from './contacts/sidebarDropdownElements.js';

let reducers = {
  //
  notification,

  //auth
  login,
  registration,
  checkLogin,
  userInfo,

  //cantacts
  friends,
  searchFriends,
  friendshipRequests,
  
  //communications

};

export default combineReducers(reducers);