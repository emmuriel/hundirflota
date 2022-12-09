
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}
// devuelve la cookie con el nombre dado,
// o undefined si no la encuentra
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }
  function checkAuth(){
    const session=getCookie('HundirFlota');
    if (!session){
        var RutaAbsoluta = getAbsolutePath();

        location.replace(`${RutaAbsoluta}index.php`);
    }
}


document.addEventListener("DOMContentLoaded", () => {
    checkAuth();
  });