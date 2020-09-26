<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Tinder Template (MATCH)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  

  <link rel="stylesheet" href="styles.css">
<style>
    /*Downloaded from https://www.codeseek.co/julessmiles/tinder-template-match-bZjOKx */
/************************
Tinder Template by Miami
************************/
@import "https://fonts.googleapis.com/css?family=Dynalight";
.tbg {
  height: 720px;
  width: 400px;
  background-color: #fff;
  margin: 0 auto;
  border: 1px solid #c0c0c0;
}

.tbgwrap {
  padding: 10px;
  filter: blur(100px);
  -webkit-filter: blur(20px);
}

.theader {
  height: 65px;
  border-bottom: 1px solid #c0c0c0;
  filter: blur(100px);
  -webkit-filter: blur(20px);
}

.theader i.fa-comments {
  color: #c0c0c0;
  font-size: 40px;
  display: inline-block;
  float: right;
  padding: 10px 20px;
  position: relative;
}

.theader i.fa-cog {
  color: #c0c0c0;
  font-size: 40px;
  display: inline-block;
  float: left;
  padding: 10px 20px;
  position: relative;
}

.tlogo {
  width: 100px;
  margin: 0 auto;
  padding: 10px;
}

.tlogo img {
  width: 100px;
}

.tphoto {
  width: 350px;
  height: 350px;
  overflow: hidden;
  margin: 0 auto;
  position: relative;
  top: 15px;
  border-radius: 10px;
  -moz-border-radius: 10px;
  -o-border-radius: 10px;
  -ms-border-radius: 10px;
  border: 1px solid #c0c0c0;
  padding-bottom: 60px;
  background-color: #fff;
  box-shadow: 2px 2px 2px #c0c0c0;
}

.tname {
  padding: 15px;
  font-size: 20px;
  font-family: 'Helvetica', sans-serif;
  float: left;
}

.tname .age {
  font-weight: 200;
}

.tinfo {
  font-family: 'Helvetica', sans-serif;
}

.tinfo .fa-users, .tinfo .fa-book {
  color: #c0c0c0;
  float: right;
  position: relative;
  font-size: 24px;
  padding: 12px;
}

.tno {
  background-color: #fff;
  height: 120px;
  width: 120px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -o-border-radius: 50%;
  -ms-border-radius: 50%;
  position: relative;
  display: inline-block;
  top: 50px;
  left: 25px;
  border: 10px solid #f0f0f0;
}

.tno i {
  color: #ff695b;
  font-size: 80px;
  padding: 17px 28px;
}

.ti {
  background-color: #fff;
  height: 50px;
  width: 50px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -o-border-radius: 50%;
  -ms-border-radius: 50%;
  position: relative;
  display: inline-block;
  left: 12px;
  top: 30px;
  border: 10px solid #f0f0f0;
}

.ti .fa-info {
  font-size: 23px;
  padding: 15px 20px;
  color: #398beb;
}

.tyes {
  background-color: #fff;
  height: 120px;
  width: 120px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -o-border-radius: 50%;
  -ms-border-radius: 50%;
  position: relative;
  display: inline-block;
  top: 48px;
  left: 0px;
  border: 10px solid #f0f0f0;
}

.tyes i {
  color: #5de19c;
  font-size: 60px;
  padding: 35px 30px;
}

.credit {
  width: 400px;
  height: auto;
  position: relative;
  top: 60px;
  text-align: center;
  background-color: #f0f0f0;
  padding: 2px 0px;
}

.credit a {
  font-size: 7px;
  letter-spacing: 5px;
  color: #c0c0c0;
  text-decoration: none;
  text-transform: uppercase;
  font-family: 'Helvetica', sans-serif;
  font-style: italic;
}

.match {
  height: 700px;
  width: 400px;
  background-color: rgba(51, 51, 51, 0.75);
  position: absolute;
  z-index: 999999;
}

.mtext {
  color: #fff;
  font-size: 80px;
  text-align: center;
  padding: 20px;
  position: relative;
  top: 50px;
  font-family: 'Dynalight', cursive;
}

.m1, .m2 {
  background-color: #fff;
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: relative;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -o-border-radius: 50%;
  -ms-border-radius: 50%;
  margin: 10px;
  display: inline-block;
  left: 30px;
  top: 40px;
}

.m1 img, .m2 img {
  width: 150px;
  height: 150px;
}

.sendmsg, .playing {
  margin: 0 auto;
  color: #fff;
  font-size: 22px;
  position: relative;
  border: 1px solid #fff;
  width: 250px;
  padding: 15px 20px 15px 50px;
  border-radius: 5px;
  -moz-border-radius: 5px;
  -o-border-radius: 5px;
  -ms-border-radius: 5px;
  top: 70px;
  font-family: 'Helvetica', sans-serif;
  font-weight: 200;
  margin-bottom: 20px;
}

.sendmsg i, .playing i {
  font-size: 30px;
  padding-right: 8px;
}

.playing i {
  padding-right: 12px;
  font-size: 34px;
}

.share {
  color: #fff;
  position: relative;
  font-family: 'Helvetica', sans-serif;
  top: 150px;
  font-size: 20px;
  font-weight: 200;
  margin: 0 auto;
  text-align: center;
}

.share i {
  font-size: 24px;
  padding: 5px;
}
</style>
  
</head>

<body>

  <div class="tbg">
  <div class="match">
    <div class="mtext">It's a Match!</div>
    <div class="m1"><img src="http://www.amicnews.com/wp-content/uploads/2015/04/Sunglasses-Trends-for-Summer-2015.jpg" /></div>
    <div class="m2"><img src="https://s-media-cache-ak0.pinimg.com/564x/d3/01/ec/d301ec7f0a9fc70a53c7b8cbf85114f0.jpg" /></div>
    <div class="sendmsg"><i class="fa fa-comment" aria-hidden="true"></i> Send a Message</div>
    <div class="playing"><i class="fa fa-user" aria-hidden="true"></i> Keep Swiping</div>
    <div class="share"><i class="fa fa-share-square-o" aria-hidden="true"></i> Tell Your Friends</div>
  </div>
  <div class="theader">
    <i class="fa fa-cog" aria-hidden="true"></i>
    <i class="fa fa-comments" aria-hidden="true"></i>
    <div class="tlogo">
      <img src="https://worldvectorlogo.com/logos/tinder-1.svg" alt="Tinder Logo" title="Tinder Logo" />
    </div>
  </div>
  <div class="tbgwrap">
    <div class="tphoto">
      <img src="http://www.amicnews.com/wp-content/uploads/2015/04/Sunglasses-Trends-for-Summer-2015.jpg" title="tphoto" alt="Tinder Photo" />
      <div class="tname">Jane Doe, <span class="age">27</span></div>
      <div class="tinfo"><i class="fa fa-book" aria-hidden="true"> 0</i><i class="fa fa-users" aria-hidden="true"> 0</i></div>
    </div>
    <div class="tcontrols">
      <div class="tno"><i class="fa fa-times" aria-hidden="true"></i></div>
      <div class="ti"><i class="fa fa-info" aria-hidden="true"></i></div>
      <div class="tyes"><i class="fa fa-heart" aria-hidden="true"></i></div>
    </div>
  </div>
  <div class="credit"><a href="http://themakery.jcink.net">Created by Miami</a></div>
</div>
  <script src='https://use.fontawesome.com/faffa271ef.js'></script>

  

</body>

</html>