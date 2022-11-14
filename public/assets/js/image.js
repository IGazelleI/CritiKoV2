function changeImage()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            var newImg = document.getElementById("imgPath").value;
            
            document.getElementById("evaluateeImg").source = newImg;
        }
    };
    xhttp.open("GET", "filename", true);
    xhttp.send();
}