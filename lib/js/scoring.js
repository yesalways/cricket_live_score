           
$(document).ready(function(){
   
    $("#extras").hide();
    $("#runs").hide();
    $("#wickets").hide();
    $("#overs").hide();

    $("#extra").click(function(){
                   $("#extras").show();
                   $("#runs").hide();
                   $("#wickets").hide();
                   $("#overs").hide();

               $("#legbye").click(function(){
                   $("#runs").show();
                   $("#runs4").show();
                   $("#runs6").hide();
               });

               $("#bye").click(function(){
                   $("#runs").show();
                   $("#runs4").show();
                   $("#runs6").hide();
               });

               $("#wide").click(function(){
                   $("#runs").show();
                   $("#runs4").show();
                   $("#runs6").hide();
               });

               $("#noball").click(function(){
                   $("#runs").show();
                   $("#runs4").show();
                   $("#runs6").show();
               });
    });

    $("#wicket").click(function(){
        $("#extras").hide();
        $("#runs").hide();
        $("#wickets").show();
        $("#overs").hide();
        
        $("#bowled").click(function(){
              $("#extras").hide();
              $("#runs").hide();
              $("#wickets").show();
        });

        $("#caught").click(function(){
            $("#extras").hide();
            $("#runs").hide();
            $("#wickets").show();
        });

        $("#stumped").click(function(){
            $("#extras").hide();
            $("#runs").hide();
            $("#wickets").show();
        });

        
        $("#lbw").click(function(){
            $("#extras").hide();
            $("#runs").hide();
            $("#wickets").show();
        });

        $("#runout").click(function(){
            $("#runs").show();
            $("#runs4").hide();
            $("#runs6").hide();
        });

    });

    $("#run").click(function(){
        $("#extras").hide();
        $("#runs").show();
        $("#runs4").show();
        $("#runs6").show();
      $("#wickets").hide();
      $("#overs").hide();

    });
});
           