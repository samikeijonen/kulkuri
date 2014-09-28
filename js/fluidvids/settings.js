/*
 * Fluidvids settings.
 *
 * Install and activate Fluidvids WordPress Plugin if you want to have control what players to support.
 * @link https://wordpress.org/plugins/fluidvids/
 */
fluidvids.init({
	selector: ['embed', 'iframe', 'object'], // runs querySelectorAll()
	players:  ['www.youtube.com', 'player.vimeo.com', 's3.amazonaws.com/embed.animoto.com', 'blip.tv', 'www.collegehumor.com', 'www.dailymotion.com', 'www.flickr.com', 'www.funnyordie.com', 'www.hulu.com', 'embed-ssl.ted.com', 'v.wordpress.com', 'www.slideshare.net', 'fast.wistia.net'] // players to support
});