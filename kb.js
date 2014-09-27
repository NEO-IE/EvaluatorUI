$(document).ready(function() {
    $(document).on("keydown", function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var left = 37;
        var up = 38;
        var right = 39;
        var down = 40;
        if (code == right) {
            document.getElementById("qtn").submit();
        } else if(code == up) {
            $("#valid").val("true");
            $("#tick").html("<span float = 'right' class='glyphicon glyphicon-ok'></span>");
        } else if(code == down) {
            $("#valid").val("false");
            $("#tick").html("<span float = 'right' class='glyphicon glyphicon-remove'></span>");
        }
    });
    });

