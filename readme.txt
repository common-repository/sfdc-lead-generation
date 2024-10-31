=== SFDC Lead Generation ===
Contributors: ksolves
Requires at least: 3.1
Tested up to: 3.9.2
Tags: wordpress to salesforce lead generation, Membership register form, registerform, wordpress to salesforce lead, wordpress lead generation, salesforce.com, salesforce, salesforce crm,profile builder, Wordpress CRM membership
Stable tag: 1.0.0
License: GPLv2 or later
Donate link: http://www.ksolves.com/

== Description ==

This plugin extends the wordpress registration form by adding up fields and registers the user as a lead on Salesforce platform (Salesforce CRM).

Major features in SFDC Lead Generation include:

* Extends the wordpress registration form including the fields required to register a lead for salesforce platform.
* Register user and add custom fields data in user meta data.
* Users are registered in wordpress and the associated salesforce account.

== Installation ==

1. Upload the `plugin` folder to the `/wp-content/plugins/` directory or install via the Add New Plugin menu
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your Salesforce.com Consumer Key, Consumer Secret, Organization ID, Password, Secret Key on the SFDC Lead Generation plugin setting page.
4. Go to Settings menu on left menu bar, then enable the option "Membership (Anyone can register)".

== Screenshots ==

1. screenshot-1.png shows the registration form including all the added fields
2. screenshot-2.png shows the backend showing SFDC Lead Generation plugin in plugin list
3. screenshot-3.png shows the backend showing setting page for SFDC Lead Generation

== Frequently Asked Questions ==

 Where i can get Consumer Key and Consumer Secret? 

In Salesforce, from Setup, click Create | Apps. Click New in the Connected Apps related list to create a new connected app.
The Callback URL you supply here is the same as your Web application's callback URL. Usually it's our plugin page url . It must be secure: http:// doesn't work, only https://. For development environments, the callback URL is similar to https://my-website/_callback. When you click Save, the Consumer Key is created and displayed, and a Consumer Secret is created (click the link to reveal it).

 Where i can get Security token?

Login to your organisation and go to the top navigation bar,then go to <your name > My Settings > Personal  >  Reset My Security Token.


== Changelog ==
= 1.0.0 =
* Remove PHPToolKit and used curl base RESTFul web service to save data on SFDC ORG.
* Added captcha on registration form.

== Upgrade Notice ==

= 1.0.0 =
* Registration of user for salesforce platform.