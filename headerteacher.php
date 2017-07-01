<style>
    
/*
.logbutton{
    border-radius:5px !important;
    border:none;
    
}
 .logbutton:link,visited,active{
    border-radius:5px !important; color:#ff8a87;
    border:none;
    
    background-color:#FFF;
}
 .logbutton:visited{
    border-radius:5px !important; color:#ff8a87;border:none;
    
    background-color:#FFF !important;
}
 .logbutton:hover{
    color:#FFF;
    background-color:#FFF;
    border:none;
    
}
 .logbutton:active{
    border-radius:5px !important; 
    color:#ff8a87;
    background-color:#FFF !important;
}
*/


</style>

<div class="row">
    <div class="col-sm-1">
    </div>


    <div class="col-sm-10 no-padding-left">
        <div class=" Lightbackground headerLight " style="border-left: none; ">
            <div class="headerIconDiv">
                <img id="btn_user_profile" class="userProfile" src="images/MenuIcons/PenHeader.png" />
                <b>Welcome, <b id="UserFullName"><?php echo $adminName; ?></b></b>
            </div>
        </div>
    </div>

   <!-- <div class="col-sm-10" style="height:5.325em; margin-top:1em; ">

            <div style="margin-left:2em; margin-right:2em;">

                <a class="pull-left hidden-xs" id="LogoSM" href="teacherpanel.php"><img src="images/logoM.png"
                                                                                          title="Ancestry Atlas"
                                                                                          alt="Ancestry Atlas"></a>
                    
                    <a href="teacherpanel.php?logoutrequest" class="btn btn-default navbar-btn logbutton submitbtunnew" style="float:right; border-radius:5px; margin:1.0em 0em; font-weight:bold;  text-decoration:none; ">LOGOUT</a>


                </div>
        </div>-->
    <div class="col-sm-1 no-padding Lightbackground headerLight" style="border-right: none">
        <!--<a id="btn_user_profile" href="#" class="btn HeaderBtn btn-default navbar-btn logbutton submitbtunnew" style="/*float:right; border-radius:5px; margin:1.0em 0em; font-weight:bold;  text-decoration:none; margin-right: 1em;*/">PROFILE</a>-->
        <a href="teacherpanel.php?logoutrequest" id="logOutBtn"
           class="btn btn-default navbar-btn logbutton HeaderBtn submitbtunnew" style="margin-top: 1.3em"><span id="logoutSpan">LOGOUT</span><i
                    id="logoutIcon" class="glyphicon glyphicon-off"></i> </a>
    </div>

</div>
