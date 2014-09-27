$(document).ready(function() {
    $(document).on("keydown", function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var left = 37;
        var up = 38;
        var right = 39;
        var down = 40;
        if (code == right) {
            $("#direction").val("1");
            document.getElementById("qtn").submit();
        } else if (code == left) {
            $("#direction").val("2");
            document.getElementById("qtn").submit();
        } else if(code == up) {
            $("#valid").val("true");
            $("#verdict").attr("src", "imgs/tick.png");
        } else if(code == down) {
            $("#valid").val("false");
            $("#verdict").attr("src", "imgs/cross.png");
        }
    });
    });

