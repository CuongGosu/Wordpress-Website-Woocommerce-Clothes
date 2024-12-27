<article class="blog-loop">
    <div class="blog-post row">
        <div class="col-md-5 col-xs-12 col-sm-12">
            <a href="<?php the_permalink() ?>" class="blog-post-thumbnail" title="<?php the_title() ?>" rel="nofollow">
                <img class="lazyload" src="<?php thePostThumbnailUrl(399,600) ?>" alt="<?php the_title() ?>">
            </a>
        </div>
        <div class="col-md-7 col-xs-12 col-sm-12">
            <h3 class="blog-post-title">
                <a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a>
            </h3>
            <div class="blog-post-meta">
                <span class="date">
                    <time pubdate=""><?php the_time('d.m.Y') ?></time>
                </span>
            </div>
            <div class="entry-content"><?php theExcerpt(25) ?></div>
        </div>
    </div>
</article>