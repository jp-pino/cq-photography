// This is "probably" IE9 compatible but will need some fallbacks for IE8
// - (event listeners, forEach loop)

// wait for the entire page to finish loading
window.addEventListener('load', function() {

	// setTimeout to simulate the delay from a real page load
	setTimeout(lazyLoad, 100);

});

function lazyLoad() {
	var collection_images = document.querySelectorAll('.collection-image');

	// loop over each collection image
	collection_images.forEach(function(collection_image) {
		var image_url = collection_image.getAttribute('data-image-full');
		var content_image = collection_image.querySelector('img');

		// change the src of the content image to load the new high res photo
		content_image.src = image_url;

		// listen for load event when the new photo is finished loading
		content_image.addEventListener('load', function() {
			// swap out the visible background image with the new fully downloaded photo
			collection_image.style.backgroundImage = 'url(' + image_url + ')';
			// add a class to remove the blur filter to smoothly transition the image change
			collection_image.className = collection_image.className + ' is-loaded';
		});

	});

}
