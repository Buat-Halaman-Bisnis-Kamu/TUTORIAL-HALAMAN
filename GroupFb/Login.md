

Plugin Sosial
Komentar
Komentar Sematan
Kiriman Sematan
Video Sematan
Plugin Grup
Tombol Suka
Plugin Halaman
Plugin Kutipan
Tombol Simpan
Tombol Bagikan
Endpoint oEmbed
Situs yang Ditujukan untuk Anak-Anak
Pertanyaan Umum
Tidak Berlaku Lagi
Di Halaman Ini
Kembali ke Bahasa Indonesia
Dokumen ini sudah diperbarui.
Terjemahan ke Bahasa Indonesia belum selesai.
Bahasa Inggris diperbarui: 14 Jul
Bahasa Indonesia diperbarui: 22 Agu 2018
Group Plugin
The Group Plugins lets people join your Facebook group from a link in an email message or a web page.

EmailWeb
Group Plugin for Email
The Group Plugin for Email allows email recipients to join your group from an email message. You generate the code to add to the message to the email service provider which then sends a message with a button to your recipients.

Use this code only in an email campaign software. Do not use the code provided in a message in an email client.
Do not use this code in a web page.
Step-by-Step
Do the following steps to get the code for the plugin.

1. Choose Email Plugin
Open the group page and choose Embed Invite.


A window appears with the code to add to your message.

2. Copy the Code to your Email Campaign Software
Copy the code to the message in your email campaign software.

Do not modify the code from the plugin.

3. Test the Plugin
Send a message to yourself to test the plugin. Once you have verified that you have received the message and can join the group from the message, you can start your campaign.

Group Plugin for the Web
The Group Plugin for the Web is a plugin that adds a button to your web page that allows anyone to join your Facebook group. The plugin uses the Facebook SDK for JavaScript, to display a button on your web page. When the user chooses this button, the user will join your group.

Do not use the code for this plugin in an email message or an email campaign software.

To use this plugin, you will need the following:

The App ID of a Facebook app that is live and available to the public. You can check if your app is live in the App Review tab of your app Dashboard. If you need a Facebook App ID, you can create by choosing this button.
Create a new Facebook App

The Facebook Group must already exist.
Code ConfiguratorCode ExampleSettings
Step-by-Step
Do the following steps to add the plugin to your web page.

1. Configure the Settings for Your Facebook App
In Settings > Basic in your app Dashboard, choose + Add Platform. In Select Platforms, choose Website.
In Site URL of Website, enter the URL where you want the plugin to appear.
In App Domains, enter the domain name of your website.
Choose Save Changes at the right side of the bottom of the window.
2. Get the Code for the Plugin
The Join Button Code Configurator below generates the necessary code that you add to your web page. In URL of group, enter the URL of your group and adjust settings like the width of your plugin button. Choose Get Code to generate the code that you can copy to your web page.

Join Button Code Configurator
Grup URL

Lebar pixel dari plugin
 Cantumkan Konteks Sosial Sertakan Metadata

Dapatkan Kode

2. Copy and Paste HTML snippet
Copy and past the snippet from the Join Button Code Configurator into the web page where you want the button to appear.

Full Code Example
Copy and paste the code example to your web page. Change <APP_ID> to the App ID of your Facebook app and <group_URL> to the URL of your Facebook group.

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
         data-href="<group_URL>" 
         data-width="280" 
         data-show-social-context="true" 
         data-show-metadata="false">
    </div>

</body>

</html>
