export const scrfToken = () => { 
 	let metas = document.getElementsByTagName('meta'); 
 	for (let i = 0; i < metas.length; i++) { 
	    if (metas[i].getAttribute("name") == "csrf-token") { 
	    	return metas[i].getAttribute("content"); 
	    }
 	}
};

export const makeUriForRequest = urn => {
	const protocol = window.location.protocol;
	const hostname = window.location.hostname;
	return protocol + '/\/' + hostname + urn;
}

export const socketConnectByUserId = new Promise(function(resolve, reject) {
  fetch( makeUriForRequest('/get-user-id'), {
    method: 'get'
  }).then(response => {
    response.json().then(httpData => {

      resolve(httpData);
      
    });
  });
});

export const cloneObject = object => {
  return JSON.parse( JSON.stringify(object) );
}