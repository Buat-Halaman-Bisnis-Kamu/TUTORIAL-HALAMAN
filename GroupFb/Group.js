<html>

<head>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=<APP_ID>&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</head>

<body>

    <!--Your Group Plugin for the Web code-->
    <div class="fb-group" 
         data-href="<https://m.facebook.com/groups/828150041001725>" 
         data-width="280" 
         data-show-social-context="true" 
         data-show-metadata="false">
    </div>

</body>

</html>
