jQuery(document).ready(function()
{

	$('.portfolio-item-outer').each(function ()
	{
		var $this = $(this),
			$project = $this.find('.projects'),
			$newEls = '',
			loaded_object = '',
			$container = jQuery('.portfolio-projects-block');

		$project.isotope({
			itemSelector : '.element',
			masonry: {columnWidth: 1}
		});

		$this.find('.option-set a').click(function()
		{
			var $this = $(this);
			// don't proceed if already selected
			if ( $this.hasClass('selected') ) return false;
			
			var $optionSet = $this.parents('.option-set'),
				options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');

			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');
			options[ key ] = value || false;
			
			$project.isotope( options );
			
			return false;
		});
	});

	$('#news').each(function () {
		var $this = $(this),
			$project = $this.find('.projects'),			
			$newEls = '',
			loaded_object = '',
			$container = jQuery('#news .projects');

		$project.isotope({
			itemSelector : '.element',
			masonry: {columnWidth: 1}
		});
		
	});

	
});