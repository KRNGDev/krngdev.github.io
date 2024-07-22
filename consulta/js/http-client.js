function doGetHTTPRequest(
  url,
  resource,
  callbackFunction,
  callbackErrorFunction
) {
  fetch(`${url}/${resource}`)
    .then((response) => {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error(`Ha ocurrido un error ${response.status}`);
      }
    })
    .then((data) => {
      callbackFunction(data);
    })
    .catch((error) => {
      callbackErrorFunction(error);
    });
}
