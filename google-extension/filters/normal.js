// normal

if (document.getElementById("styleID")) {
    stylingID = document.getElementById("styleID").remove();
    filterID = document.getElementById("filterID").remove();
}
stylingID = document.createElement('style');
stylingID.id = "styleID";
document.body.appendChild(stylingID);

filterID = document.createElement('div');
filterID.id = "filterID";
filterID.setAttribute('style', 'height: 0; padding: 0; margin: 0; line-height: 0;');
document.body.appendChild(filterID);

stylingID.innerHTML = 'html{-webkit-filter:none;-moz-filter:none;-ms-filter:none;-o-filter:none;filter:none;}';
setTimeout(function() {
    window.scrollBy(1, 1);
    window.scrollBy(-1, -1);
}, 1);