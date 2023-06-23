window.addEventListener('DOMContentLoaded', function() {
    console.log("loadinggg");
    var urlParams = new URLSearchParams(window.location.search);
    var code = urlParams.get('id');
    console.log(code);
    if (code) {
      var codeElement = document.getElementById('code');
      codeElement.textContent = `Code: ${code}`;
    }
});