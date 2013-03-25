<? if(isset($_GET['floogle'])){ ?>
    <form method="get" action="http://google.com">
        <input style="padding:50px;width:100%;font-size:70px;" type="text" name="q" placeholder="Search Floogle" />
    </form>
<? } else { ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Prankio! An prank call app using the Twilio API by @jboesch</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet/less" type="text/css" href="less/style.less" />
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css" />
</head>
<body>

<a href="https://github.com/jboesch/Prankio"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>

    <div id="top-nav">
        <div class="inner">
            <ul class="clearfix">
                <li>
                    <a href="#" id="what-is">What is this?</a>
                    <div id="what-is-description" style="display:none">
                        <p>This is an app that was built to make prank calls using the Twilio API.</p>
                        <p>You enter the phone number of the person you're trying to call, followed by one or more messages.</p>
                        <p>You can add pauses between messages to allow the person you're pranking to respond to your fake questions.</p>
                        <p>After you're done entering your content, enter your email below and we'll send you the recording of the call!</p>

                    </div>
                </li>
                <li><a href="http://api.twilio.com/2010-04-01/Accounts/ACbb04a110a590d5d39e6b44292cdfeca0/Recordings/REdf0266081e1ed8df6dee011746ddb193.mp3">Listen to a sample</a></li>
            </ul>
        </div>
    </div>
    <div id="container">
        <h1><a href="#">Prankio</a></h1>

        <form>
            <input type="text" id="phone" placeholder="Phone number (including area code)" />
            <textarea class="message" placeholder="Your message. Example: Hide yo kids! Hide yo wife!"></textarea>

            <div class="extra-boxes"></div>

            <div class="add-boxes">
                <button class="add-message blue">Add message box</button>
            </div>

            <h3 class="grey-line"><span>All done?</span></h3>

            <div class="email-me-recording">

                <div class="email-me-container">
                    <div class="checkbox">
                        <input type="checkbox" id="email-me" checked/>
                    </div>
                    <h3>Email me the recording</h3>
                    <div class="clear"></div>
                    <div class="email-container">
                        <input type="text" class="email" placeholder="forkmy@dongle.com" />
                    </div>
                </div>

                <div class="submit">
                    <button class="green">Submit this hilariousness</button>
                </div>

            </div>
        </form>

        <div class="credits">A brainchild of <a href="http://twitter.com/jboesch">@jboesch</a></div>

    </div>

<script src="js/jquery.qtip.min.js"></script>
    <script src="js/underscore.min.js"></script>
    <script src="js/backbone.min.js"></script>
    <script src="js/jquery.scrollto.min.js"></script>


    <script src="js/less.js"></script>
    <script src="js/Prankio.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#what-is').qtip({
                content: {
                    text: function(api) {
                        return $('#what-is-description').html();
                    }
                },
                position: {
                    my: 'top center',
                    at: 'bottom center'
                },
                style: {
                    classes: 'qtip-shadow qtip-bootstrap'
                }
            });

            new Prankio.View.AddMessageBox({
                el: $('.add-message'),
                appendToEl: $('.extra-boxes')
            });

            new Prankio.View.EmailMeRecording({
                el: $('.email-me-recording')
            });

            new Prankio.View.Form({
                el: $('form')
            });
        });
    </script>
</body>
</html>
<? } ?>