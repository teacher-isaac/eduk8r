(function() {
	function extLinksTarget(target) {
		let links = document.links;
		for (let i=0; i<links.length; ++i) {
			if (links[i].hostname != window.location.hostname)
				links[i].target = target;
		}
	}

	document.addEventListener('DOMContentLoaded', (event) => {
		extLinksTarget('_blank');
	});
})();
