import { combineReducers } from 'redux';
import { registration } from './auth/registration.js';
import { checkLogin } from './auth/checkLogin.js';
import { userInfo } from './auth/userInfo.js';
import { login } from './auth/login.js';
import { friendshipRequests } from './contacts/friends/friendshipRequests.js';
import { sidebarDropdownElements } from './sidebarDropdownElements.js';
import { searchFriends } from './contacts/friends/searchFriends.js';
import { friends } from './contacts/friends/friends.js';
import { groups } from './contacts/groups/groups.js';
import { makeNewGroup } from './contacts/groups/makeNewGroup.js';
import { selectedContact } from './contacts/selectedContact.js';
import { notification } from './notification';
import { messages } from './messages.js';
import { history } from './history.js';

let reducers = {

  notification,
  sidebarDropdownElements,

  //>auth
  login,
  userInfo,
  checkLogin,
  registration,
  //<

  //> contacts

    //> friends
    friends,
    searchFriends,
    friendshipRequests,
    //<

    //> groups
    groups,
    makeNewGroup,
    //<

  selectedContact,
  //<

  messages,
  history
};

export default combineReducers(reducers);