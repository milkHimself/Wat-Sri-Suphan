<?php 
	

include_once('gallery.php');
	
	$g = new Gallery;
	$glist = $g->getGalleryItemListBySection("4");
	
	echo count($glist['ID']);
																
	for($i = 0; $i < count($glist['ID']); $i++){
	
	$tmpPic = new Picture;
	$tmpPic->getPropsByID($glist['PictureID'][$i]);
	
	echo '<article class="portfolio-projects-item element">
                                    <figure><img src="data:image/jpeg;base64,' . base64_encode($tmpPic->getPicture()) . '" alt="img"></figure>

                                    <div class="portfolio-projects-caption bg-color">
                                        <a class="portfolio-projects-zoom icon-search text-color" href="data:image/jpeg;base64,' . base64_encode($tmpPic->getPicture()) . '" rel="prettyPhoto[portfolio1]"></a>
                                        <span class="title-caption">'.$glist['Name'][$i].'</span>

                                        <p class="text-caption">'.$glist['Description'][$i].'</p>
                                    </div>
                                </article>';
								
	}
								
?>