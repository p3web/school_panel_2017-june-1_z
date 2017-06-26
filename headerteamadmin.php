<style>

    /*
    .logbutton{
        border-radius:5px !important;
        color:#ff8a87;
        border:2px solid #FFF;
        background-color:#FFF;

    }
     .logbutton:link, .logbutton:visited{
        border-radius:5px !important;
        color:#ff8a87;
        border:2px solid #FFF;
        background-color:#FFF;
    }

     .logbutton:active, .logbutton:hover{
        border-radius:5px !important;
        border:2px solid #FFF;
        background-color:#ff8a87;
        color:white !important;

    }
    */


</style>

<div class="row" style="">
    <div class="col-sm-1">
    </div>


    <div class="col-sm-10 no-padding-left">
        <div class=" Lightbackground headerLight " style="border-left: none; ">
            <div class="headerIconDiv">
                <img id="headerIcon" src="images/MenuIcons/Pen.png"/>
                <b>Welcome, <b id="UserFullName"><?php echo $adminName; ?></b></b>
            </div>
        </div>
    </div>

    <!--   <div class="col-sm-10" style="height:5.325em; margin-top:1em; ">

               <div style="margin-left:2em; margin-right:2em;">


                   <a class="pull-left hidden-xs" id="LogoSM" href="teamadminpanel.php"><img src="images/logoM.png"
                                                                            title="Ancestry Atlas"
                                                                            alt="Ancestry Atlas"></a>

                   <a href="teamadminpanel.php?logoutrequest"class="btn btn-default navbar-btn logbutton submitbtunnew" style="float:right; border-radius:5px; margin:1.0em 0em; font-weight:bold;  text-decoration:none;">LOGOUT</a>

                   <a id="btn_user_profile" href="#"class="btn btn-default navbar-btn logbutton submitbtunnew" style="float:right; border-radius:5px; margin:1.0em 0em; font-weight:bold;  text-decoration:none; margin-right: 1em;">PROFILE</a>


               </div>
       </div>-->

    <!--<div class="col-sm-1">
            </div>-->


    <div class="col-sm-1 no-padding Lightbackground headerLight" style="border-right: none">
        <a id="btn_user_profile" href="#" class="btn btn-default navbar-btn logbutton submitbtunnew HeaderBtn " style="/*float:right; border-radius:5px; margin:1.0em 0em; font-weight:bold;  text-decoration:none; margin-right: 1em;*/">PROFILE</a>
        <a href="teamadminpanel.php?logoutrequest" id="logOutBtn"
           class="btn btn-default navbar-btn logbutton submitbtunnew HeaderBtn"><span id="logoutSpan">LOGOUT</span><i
                    id="logoutIcon" class="glyphicon glyphicon-off"></i> </a>
    </div>


</div>
